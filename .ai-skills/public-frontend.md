# Public Frontend

*   **Public Views Location**: Located in `resources/views/public/`. All views are written using Laravel Blade templates.
*   **Confirmed View Files**:
    1.  `home.blade.php`: The blog landing page. Displays featured articles list, recent posts, categories, and timelines.
    2.  `article.blade.php`: The full article view page. Expects variable `$slug`.
    3.  `category.blade.php`: Filters and lists articles belonging to a specific category. Expects variable `$slug`.
    4.  `tag.blade.php`: Lists articles tagged with a specific tag. Expects variable `$slug`.
    5.  `author.blade.php`: Displays author profile details and their written posts. Expects variable `$slug`.
    6.  `search.blade.php`: Lists search results based on search input `request('q')`.
*   **Layouts & Components**:
    *   No shared layouts folder is currently initialized under `resources/views/public/` (Not confirmed).
*   **Assets & Styling**:
    *   Vite is configured to load main JS/CSS entrypoints: `resources/css/app.css` and `resources/js/app.js`.
    *   Tailwind v4 is installed via Vite in `package.json` (`devDependencies`: `@tailwindcss/vite`, `tailwindcss`).
    *   Custom CSS rules should be written to preserve page performance.
