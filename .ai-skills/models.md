# Models

*   **Model List & Location**: Located in `app/Models/`. All classes extend standard Eloquent `Model` (except `User` which extends `Authenticatable`).
*   **Fillable / Guarded Patterns**:
    *   Models are generally configured with `$fillable` columns to permit bulk insertions, except for complex entities like `Post`, `Page`, and `ActivityLog` which utilize `$guarded = []` for complete property flexibility.
*   **Casts**:
    *   `User`: `email_verified_at` => `datetime`, `password` => `hashed`
    *   `Post`: `published_at` => `datetime`, `scheduled_at` => `datetime`, `faq` => `array`, `sources` => `array`, `key_facts` => `array` (Note: DB schema stores faq/sources/key_facts in dedicated relational tables, so models will typically map via relationships instead of array casts. Verify during controller bindings).
*   **Confirmed Relationships**:
    *   `User`: HasMany `Post`, HasMany `Media`
    *   `Role`: BelongsToMany `Permission`, BelongsToMany `User` (using custom user_roles pivot)
    *   `Permission`: BelongsToMany `Role` (using custom role_permissions pivot)
    *   `Category`: HasMany `Post`, BelongsTo `Category` (`parent`), HasMany `Category` (`children`)
    *   `Tag`: BelongsToMany `Post` (using custom `post_tags` pivot)
    *   `Media`: BelongsTo `User` (uploader)
    *   `Post`: BelongsTo `User` (`user`), BelongsTo `Category` (`category`), BelongsToMany `Tag` (`tags`), HasMany `Comment` (`comments`), HasMany `PostMeta` (`meta`), HasMany `PostFaq` (`faqs`), HasMany `PostSource` (`sources`), HasMany `PostRelated` (`related`), HasMany `PostInternalLink` (`internalLinks`)
    *   `PostMeta`: BelongsTo `Post`
    *   `Comment`: BelongsTo `Post`, BelongsTo `User`, BelongsTo `Comment` (`parent`), HasMany `Comment` (`children`)
    *   `Menu`: HasMany `MenuItem`
    *   `MenuItem`: BelongsTo `Menu`, BelongsTo `MenuItem` (`parent`), HasMany `MenuItem` (`children`)
*   **Scopes**:
    *   Not confirmed in the current models skeleton.
