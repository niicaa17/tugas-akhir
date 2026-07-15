Hugging Face Space deployment instructions for this Laravel app

Overview
- This repository contains a full Laravel application. The `Dockerfile` and `start.sh` are prepared to run the app inside a Hugging Face Space container.

Quick notes
- The container starts the built-in Laravel server on port `8080`.
- By default the container uses SQLite (simple, file-based). To use SQLite nothing else is required.
- For production-grade usage consider an external managed database and proper webserver (nginx + php-fpm).

Setup & push to Hugging Face Spaces
1. Create a new Space on Hugging Face: choose type "Other / Docker".
2. Clone the Space repo locally or add this repo as a remote:

```
git remote add hf https://huggingface.co/spaces/nisa17/tugas-akhir.git
git push hf main
```

3. Configure Secrets: in the Space settings add any environment variables you need (for example `APP_ENV`, `APP_DEBUG`, `DB_CONNECTION`, `DB_DATABASE`, `APP_KEY`).

Using SQLite (recommended for quick demo)
- No extra DB setup required. The container will create `/app/database/database.sqlite` automatically.

Using external DB
- Set `DB_CONNECTION`, `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD` in Space Secrets.

Common troubleshooting
- If build fails due to node or composer cache, try building locally and push built `public` assets.
- Check Space build logs in the Hugging Face UI for errors.

Next steps I can do for you
- (Optional) Create the Space repo on Hugging Face via the CLI and push the code.
- (Optional) Add `.github/workflows` to automate deploys.
