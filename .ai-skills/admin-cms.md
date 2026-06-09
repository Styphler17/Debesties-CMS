# Admin CMS

*   **Admin Views Location**: Located in `resources/views/admin/`.
*   **Design Tokens Layout**:
    *   Linked layout file: [app.blade.php](file:///c:/MAMP/htdocs/Debesties-CMS/resources/views/admin/layouts/app.blade.php).
    *   Styles: Loaded from [admin.css](file:///c:/MAMP/htdocs/Debesties-CMS/public/assets/admin/css/admin.css) using design variables (e.g. `--cms-bg`, `--cms-surface`, `--cms-gold`).
    *   Icons: Uses Lucide script CDN to dynamically compile `<i data-lucide="..."></i>` tags.
    *   Collapsible Sidebar: Uses vanilla JS collapse mechanisms saved in `localStorage`.
*   **Built View Files** (fully implemented — not stubs):
    *   `dashboard/index.blade.php`: Rich UI page with greeting banner, 6-stat grid, quick actions, SVG sparklines, trending categories, traffic bar chart, content decay alerts, and activity feed.
    *   `posts/index.blade.php`: Full posts list with status tabs, filter bar, sortable table, bulk actions, per-row dropdown menus, SEO score bars, delete modal.
    *   `posts/create.blade.php`: Full post creation form — Playfair Display title + subtitle, rich editor, SEO SERP preview, publish sidebar, featured image upload, category list, tag chip input.
    *   `posts/edit.blade.php`: Same as create, pre-populated.
    *   `categories/index.blade.php`: Two-column category management with category tree display and live add/edit form panel.
    *   `tags/index.blade.php`: Tag cloud display color-coded by volume, tag lists, inline-editable tags, and bulk deletion.
    *   `media/index.blade.php`: Media library manager with grid/list toggles, drag-and-drop upload zone, upload progress, detail slide-in inspector, and bulk actions.
    *   `calendar/index.blade.php`: Editorial calendar month/week grid view with scheduled posts, mini upcoming scheduled sidebar, and new scheduled post creation.
    *   `analytics/index.blade.php`: Date range filters, visitor stats cards, SVG daily traffic bar chart, top posts list, referral progress bars, country share breakdown.
    *   `seo/index.blade.php`: Tabbed SEO health gauge audit, site-wide missing meta card alerts, search-filtered post meta editor, and internal link builder.
    *   `ai-visibility/index.blade.php`: Bot-by-bot block/allow controls, sitemap exposure options, json-ld schema toggles, and live robots.txt rules preview.
    *   `users/index.blade.php`: Users list with status tabs, invite user modal with role assignment, status updates, and delete confirm safeguards.
    *   `roles/index.blade.php`: Split roles listing, inline role renaming, capabilities matrix checkbox grid (read, write, delete) with systems roles lock.
    *   `comments/index.blade.php`: Comment list with moderation tabs, checkable rows for bulk approval/spam/delete, nested reply thread expansion, and quick replying.
    *   `settings/index.blade.php`: Three-section general/SEO/media accordion settings with compressor sliders, dynamic formats checklists, and success save toasts.
    *   `menus/index.blade.php`: Drag/indentation-based visual menu hierarchy tree builder with L-shape tree connectors, inline item add forms, and menu location mappings.
    *   `homepage-builder/index.blade.php`: Draggable homepage sections builder layout with widget library palette, section arrangement canvas, and dynamic variable configuration inspector.
*   **Still Stub Placeholders**:
    *   `posts/show.blade.php`: Unused view placeholder.
*   **Post Form Field Names** (must match `posts` DB schema exactly):
    *   `title`, `subtitle`, `slug`, `excerpt`, `body`, `status` (enum: draft/review/approved/scheduled/published/archived), `visibility`, `scheduled_for` (datetime — shown only when status=scheduled), `featured_image_id` (resolved from media upload), `author_id`, `category`, `tags`
    *   SEO fields live in `post_meta` table: `seo_title`, `meta_description`, `focus_keyword`, `canonical_url`, `og_title`, `og_description`

