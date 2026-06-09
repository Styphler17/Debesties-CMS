# Coding Rules

*   **Laravel Monolith Boundaries**: All views, layouts, and logic must exist inside this repository. Do not build separate front-end systems.
*   **Blade Layouts**: Use Blade templates for both public views and admin panels. Link layout headers and views natively.
*   **Custom Styling**: Write clean, modern CSS. Avoid importing heavy framework tools (like Tailwind CSS) for admin CMS views unless requested.
*   **Javascript**: Use pure Vanilla JS or small Alpine.js parameters. Avoid NPM bundlers or building client side applications.
*   **Thin Controllers**: Keep controllers thin. Outsource logic tasks to the corresponding `Actions` or `Services`.
*   **Use Actions for Tasks**: Perform discrete operations (e.g. creating/deleting a post) using single-responsibility action classes in `app/Actions/`.
*   **Form Request Validation**: Validate incoming HTTP requests using dedicated Form Request classes under `app/Http/Requests/` (Not confirmed in current empty request directories).
*   **Authorization Policies**: Protect resources using Laravel Policies (`app/Policies/`) linked to specific model CRUD actions.
*   **No Duplicate Abstractions**: Before creating a service, action, helper, or class, verify that one doesn't already exist under `app/` or `database/`.
*   **No Unnecessary Packages**: Do not run composer/npm installations unless explicitly requested. Avoid external packages for simple logic tasks.
