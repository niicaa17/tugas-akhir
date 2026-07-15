FROM php:8.3-cli

ENV COMPOSER_ALLOW_XDEBUG=0 \
    APP_ENV=production \
    APP_DEBUG=false \
    PORT=8080

RUN apt-get update && apt-get install -y \
    git \
    unzip \
    zip \
    libzip-dev \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libicu-dev \
    curl \
    gnupg \
    ca-certificates \
    && docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd intl zip \
    && rm -rf /var/lib/apt/lists/*

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Install Node.js (for building assets)
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - \
    && apt-get update && apt-get install -y nodejs && rm -rf /var/lib/apt/lists/*

WORKDIR /app

# Install PHP deps using composer (optimised). Copy composer files first.
COPY composer.json composer.lock /app/
RUN composer install --no-dev --prefer-dist --no-interaction --optimize-autoloader || true

# Install frontend deps if present
COPY package*.json /app/
RUN if [ -f package.json ]; then npm install && npm run build || true; fi

# Copy application
COPY . /app

# Try generate key and fix permissions (idempotent)
RUN php artisan key:generate --force || true
RUN chown -R www-data:www-data /app/storage /app/bootstrap/cache || true

EXPOSE 8080

COPY start.sh /start.sh
RUN chmod +x /start.sh

CMD ["/start.sh"]
