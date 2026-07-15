#!/bin/sh
set -e

# Default to sqlite when DB_CONNECTION not set
if [ -z "$DB_CONNECTION" ]; then
  export DB_CONNECTION=sqlite
  export DB_DATABASE=/app/database/database.sqlite
fi

# Prepare sqlite file if using sqlite
if [ "$DB_CONNECTION" = "sqlite" ]; then
  mkdir -p /app/database
  if [ ! -f "$DB_DATABASE" ]; then
    touch "$DB_DATABASE"
  fi
fi

# Run migrations (ignore failures in readonly environments)
php artisan migrate --force || true
php artisan storage:link || true

# Start the Laravel development server
php artisan serve --host=0.0.0.0 --port=${PORT:-8080}
