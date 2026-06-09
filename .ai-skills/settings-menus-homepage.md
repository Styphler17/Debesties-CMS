# Settings, Menus, & Homepage

*   **Settings Model Usage**:
    *   `Setting` model maps site settings using columns: `key` (unique), `value`, `type`, `group`.
    *   `SettingSeeder` populates `site_name` ("Debesties CMS") and `site_description` ("Premium CMS Platform").
    *   `SettingsService` manages key value parsing and retrieval.
*   **Menu & MenuItem Relationships**:
    *   `Menu` hasMany `MenuItem` elements.
    *   `MenuItem` belongsTo `Menu`, belongsTo `MenuItem` (`parent`), hasMany `MenuItem` (`children` ordered by `sort_order`).
    *   `MenuItem` defines column `type` as enum: `custom`, `page`, `category`, `tag`, `post` and maps to references using `reference_id`.
*   **Homepage Builder**:
    *   `HomepageBuilderController@index` renders the backend widget/homepage layout views.
    *   Specific widget storage structures or JSON parameters are Not confirmed.
*   **Admin Views**:
    *   `settings/index.blade.php`: Configures global site options.
    *   `menus/index.blade.php`: Manages nav links and footer structures.
    *   `homepage-builder/index.blade.php`: Renders structural widgets.
*   **Front-end Integration**:
    *   The retrieval of dynamic menus or site settings in the public views is Not confirmed.
