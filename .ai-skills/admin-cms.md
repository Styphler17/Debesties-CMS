# Admin CMS

*   **Admin Views Location**: Located in `resources/views/admin/`.
*   **Design Tokens Layout**:
    *   Linked layout file: [app.blade.php](file:///c:/MAMP/htdocs/Debesties-CMS/resources/views/admin/layouts/app.blade.php).
    *   Styles: Loaded from [admin.css](file:///c:/MAMP/htdocs/Debesties-CMS/public/assets/admin/css/admin.css) using design variables (e.g. `--cms-bg`, `--cms-surface`, `--cms-gold`).
    *   Icons: Uses Lucide script CDN to dynamically compile `<i data-lucide="..."></i>` tags.
    *   Collapsible Sidebar: Uses vanilla JS collapse mechanisms saved in `localStorage`.
*   **Confirmed View Files**:
    *   `dashboard/index.blade.php`: Rich UI page containing greeting banner, stat grids, quick actions, SVG sparklines, trending progress bars, traffic charts, and activity logs.
    *   `posts/`: Folder with `index.blade.php`, `create.blade.php`, `show.blade.php`, `edit.blade.php` placeholders.
    *   `categories/`: Folder with CRUD placeholders.
    *   `tags/`: Folder with CRUD placeholders.
    *   `media/`: Folder with `index.blade.php`, `show.blade.php` placeholders.
    *   `calendar/`: `index.blade.php` placeholder for editorial scheduling calendar.
    *   `analytics/`: `index.blade.php` placeholder for tracking views/clicks.
    *   `seo/`: `index.blade.php` placeholder for managing global SEO configurations.
    *   `ai-visibility/`: `index.blade.php` placeholder for LLM index blockers and robots rules.
    *   `users/`: Folder with CRUD placeholders.
    *   `roles/`: Folder with CRUD placeholders.
    *   `comments/`: Folder with `index.blade.php`, `show.blade.php`, `edit.blade.php` placeholders.
    *   `settings/`: `index.blade.php` placeholder for site configurations.
    *   `menus/`: `index.blade.php` placeholder for navigation builders.
    *   `homepage-builder/`: `index.blade.php` placeholder for widget layout managers.
