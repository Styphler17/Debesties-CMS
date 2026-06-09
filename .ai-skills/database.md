# Database

*   **Migration Naming Patterns**: Structured using chronological timestamps under `database/migrations/` using Laravel 11's default ordering schema format: `0001_01_01_xxxxxx_create_tablename_table.php`.
*   **Confirmed Tables**:
    1.  `users`: Standard Laravel users columns + `avatar`, `bio`, `status` (enum: active, suspended), `last_login_at`, softDeletes.
    2.  `password_reset_tokens` & `sessions` (standard Laravel session tables).
    3.  `roles`: `id`, `name`, `slug` (unique).
    4.  `permissions`: `id`, `name`, `slug` (unique).
    5.  `role_permissions`: Pivot table mapping roles to permissions (cascade on delete).
    6.  `user_roles`: Pivot table mapping users to roles (cascade on delete).
    7.  `categories`: `name`, `slug` (unique), `description` (nullable), `parent_id` (foreign, self-referential categories), `sort_order`, `is_visible`, softDeletes.
    8.  `tags`: `name`, `slug` (unique), softDeletes.
    9.  `media`: `user_id` (foreign), `file_name`, `file_path`, `file_url`, `mime_type`, `file_size`, `alt_text`, `caption`, `title`, `folder`, `width`, `height`, softDeletes.
    10. `posts`: `user_id` (foreign), `category_id` (foreign, nullable), `title`, `slug` (unique), `subtitle`, `excerpt`, `body` (longtext), `status` (enum: draft, review, approved, scheduled, published, archived), `featured_image_id` (foreign to media, nullable), `published_at`, `scheduled_for`, `view_count`, `comment_count`, softDeletes.
    11. `post_meta`: `post_id` (foreign), `seo_title`, `meta_description`, `focus_keyword`, `canonical_url`, `og_title`, `og_description`, `og_image_id` (foreign to media), `twitter_card`.
    12. `post_tags`: Pivot table mapping posts to tags.
    13. `post_faqs`: `post_id` (foreign), `question`, `answer`, `sort_order`.
    14. `post_sources`: `post_id` (foreign), `source_title`, `source_url`, `published_at`, `sort_order`.
    15. `post_related`: `post_id` (foreign), `related_post_id` (foreign to posts), `sort_order`.
    16. `post_internal_links`: `post_id` (foreign), `anchor_text`, `target_url`, `sort_order`.
    17. `post_quick_answers`: `post_id` (foreign), `question` (nullable), `answer` (text), `sort_order`.
    18. `post_key_facts`: `post_id` (foreign), `label`, `value`, `sort_order`.
    19. `comments`: `post_id` (foreign), `user_id` (foreign, nullable), `name`, `email`, `comment`, `status` (enum: pending, approved, rejected, spam), `parent_id` (foreign, self-referential comments), softDeletes.
    20. `feedback`: `post_id` (foreign, nullable), `name`, `email` (nullable), `message`, `status` (enum: new, reviewed, closed).
    21. `pages`: `user_id` (foreign), `title`, `slug` (unique), `body` (longtext), `status` (enum: draft, published), softDeletes.
    22. `menus`: `name`, `location` (nullable).
    23. `menu_items`: `menu_id` (foreign), `parent_id` (foreign, self-referential menu_items), `title`, `url`, `type` (enum: custom, page, category, tag, post), `reference_id` (nullable), `sort_order`.
    24. `settings`: `key` (unique), `value` (longtext, nullable), `group` (nullable).
    25. `activity_logs`: `user_id` (foreign, nullable), `action`, `model_type` (nullable), `model_id` (nullable), `details` (json, nullable).
