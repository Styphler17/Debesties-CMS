# Deployment

*   **Hosting Target**: Target server environment is Hostinger shared/cloud hosting.
*   **Database Engine**: MariaDB database compatibility is required.
*   **Document Root Entry Point**: The web server entry point must map to `public/index.php`.
*   **Storage Symlink**: Run `php artisan storage:link` upon deployment to link `storage/app/public/` to `public/storage` so that uploaded images are readable by the browser.
*   **Asset Management**: Run `npm run build` locally or during deployment tasks to bundle public stylesheet configurations via Vite.
*   **Caching & Optimization**:
    *   Optimizations to run in production:
        *   `php artisan config:cache`
        *   `php artisan route:cache`
        *   `php artisan view:cache`
*   **Scheduler & Queues**:
    *   Shared hosting targets typically lack persistent supervisor queue workers.
    *   Queues must be configured to run via cron triggers (e.g. running `php artisan queue:work --once` or `php artisan queue:listen` in a cron tab) if database queue is used.
    *   Configure a Cron job on Hostinger running `* * * * * php artisan schedule:run >> /dev/null 2>&1` to support article scheduling.
*   **Key Environment Variables** (configured in `.env`):
    *   `APP_ENV=production`
    *   `APP_KEY` (Required encryption key)
    *   `DB_CONNECTION=mysql` (MariaDB connection parameters)
    *   `QUEUE_CONNECTION=sync` (Default to sync if background queue daemon is unavailable on host)
