# Architecture

*   **Structure**: Classic Laravel Monolith. All backend endpoints, business logic, DB seeding, and view templates exist in the same codebase.
*   **Controller Organization**:
    *   Separated into two subdirectories under `app/Http/Controllers/`:
        *   `Public/`: Anonymous public-facing controllers (e.g. `HomeController`, `ArticleController`, `SitemapController`).
        *   `Admin/`: Authenticated CMS administrative controllers (e.g. `DashboardController`, `PostController`, `CategoryController`).
*   **Service Organization**:
    *   Located in `app/Services/`.
    *   Contains business logic calculations and API integrations.
    *   Confirmed Services: `PostService`, `MediaService`, `SeoService`, `AnalyticsService`, `AiVisibilityService`, `MenuService`, `SettingsService`.
*   **Action Organization**:
    *   Located in `app/Actions/`. Used for fine-grained task handling (Single Responsibility Principle).
    *   Subfolders structure:
        *   `Posts/`: `CreatePost.php`, `UpdatePost.php`, `DeletePost.php`, `PublishPost.php`, `SchedulePost.php`.
        *   `Media/`: `UploadMedia.php`, `DeleteMedia.php`, `GenerateImageVariants.php`.
        *   `SEO/`: `GenerateSlug.php`, `BuildMetaData.php`, `SuggestInternalLinks.php`.
*   **Model Organization**:
    *   Located in `app/Models/`. Standard Eloquent Model classes referencing their tables.
*   **Blade View Organization**:
    *   Located in `resources/views/`:
        *   `public/`: Blade views for the front-end blog website (e.g. `home.blade.php`, `article.blade.php`).
        *   `admin/`: Blade views for the administrative CMS (e.g. `dashboard/`, `posts/`, `categories/`, `tags/`). Organized into directories matching controller resources.
*   **Jobs & Observers Usage**:
    *   Jobs (`app/Jobs/`): Queue-based asynchronous handlers. Confirmed: `PublishScheduledPost`, `OptimizeMedia`, `GenerateSeoSuggestions`.
    *   Observers (`app/Observers/`): Eloquent lifecycle hooks. Confirmed: `PostObserver`, `MediaObserver`, `UserObserver`.
