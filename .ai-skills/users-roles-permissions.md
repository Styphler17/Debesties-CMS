# Users, Roles, & Permissions

*   **RBAC Architecture**:
    *   Custom tables `roles`, `permissions`, `role_permissions` (pivot), and `user_roles` (pivot) handle access control.
    *   No external package dependencies (like Spatie) are currently integrated in the database structure, meaning authorization uses custom Laravel pivot queries and gates/policies.
*   **Confirmed Models**:
    *   `User`: Represents CMS editors, writers, and administrators.
    *   `Role`: Represents role groups.
    *   `Permission`: Represents individual abilities (e.g. `manage-posts`).
*   **Access Policies** (`app/Policies/`):
    *   `PostPolicy`: Authorization rules for viewing, editing, creating, and deleting posts.
    *   `MediaPolicy`: Controls uploading and deleting files.
    *   `UserPolicy`: Restricts editing and deleting user profiles.
    *   `CommentPolicy`: Restricts comment approvals and deletion.
*   **Administrative Access Rules**:
    *   Admin routes require the middleware group `['auth', 'admin']` (defined in `routes/admin.php`). The definition of the `admin` middleware/gate check is Not confirmed.
*   **Seeded Roles and Permissions**:
    *   `RoleSeeder` seeds: `Administrator`, `Editor`, `Author`.
    *   `PermissionSeeder` seeds: `Manage Posts`, `Manage Users`, `Manage Settings`.
    *   `UserSeeder` seeds: `Admin User` (`admin@debesties.local` / `password`).
