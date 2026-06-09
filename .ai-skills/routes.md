# Routes

*   **Public Route Structure** ([routes/web.php](file:///c:/MAMP/htdocs/Debesties-CMS/routes/web.php)):
    *   `/` -> `HomeController@index` (name: `home`)
    *   `/search` -> `SearchController@index` (name: `search`)
    *   `/author/{user:slug}` -> `AuthorController@show` (name: `authors.show`)
    *   `/category/{category:slug}` -> `CategoryController@show` (name: `categories.show`)
    *   `/tag/{tag:slug}` -> `TagController@show` (name: `tags.show`)
    *   `/{post:slug}` -> `ArticleController@show` (name: `posts.show`)
*   **Admin Route Structure** ([routes/admin.php](file:///c:/MAMP/htdocs/Debesties-CMS/routes/admin.php)):
    *   All admin routes are prefix-grouped under `/admin`, use route name prefix `admin.`, and apply the middleware group `['auth', 'admin']`.
    *   `/admin` -> `DashboardController@index` (name: `admin.dashboard`)
    *   `/admin/posts` (Resource) -> `PostController`
    *   `/admin/categories` (Resource) -> `CategoryController`
    *   `/admin/tags` (Resource) -> `TagController`
    *   `/admin/media` (Partial Resource: index, store, show, destroy) -> `MediaController`
    *   `/admin/users` (Resource) -> `UserController`
    *   `/admin/roles` (Resource) -> `RoleController`
    *   `/admin/comments` (Resource) -> `CommentController`
    *   `/admin/calendar` -> `CalendarController@index` (name: `admin.calendar.index`)
    *   `/admin/analytics` -> `AnalyticsController@index` (name: `admin.analytics.index`)
    *   `/admin/menus` -> `MenuController@index` (name: `admin.menus.index`)
    *   `/admin/settings` -> `SettingController@index` (name: `admin.settings.index`)
    *   `/admin/seo` -> `SeoController@index` (name: `admin.seo.index`)
    *   `/admin/ai-visibility` -> `AiVisibilityController@index` (name: `admin.ai-visibility.index`)
    *   `/admin/homepage-builder` -> `HomepageBuilderController@index` (name: `admin.homepage-builder.index`)
*   **API Route Usage** ([routes/api.php](file:///c:/MAMP/htdocs/Debesties-CMS/routes/api.php)):
    *   Placeholder file created. No actual active API endpoints are currently defined.
*   **Authentication Routes**:
    *   `routes/auth.php` is loaded as a placeholder group under the `web` middleware, but is currently empty.
*   **Route Setup**:
    *   Configured in `bootstrap/app.php` using Laravel 11's Application Builder routing configurations.
