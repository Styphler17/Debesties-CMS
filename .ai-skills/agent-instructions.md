# Agent Instructions

Welcome, future coding agent! Please follow these guidelines strictly when working in this codebase:

## Step-by-Step Task Reading

1.  **First**: Read `project-overview.md` to understand the goal, stack, and modules.
2.  **Second**: Read `architecture.md` to see the structure and patterns of Controllers, Actions, Services, and Models.
3.  **Third**: Read only the specific skill file related to your current task (e.g. `media-library.md` for uploading tasks).
4.  **Avoid Full Code Scanning**: Do not recursively search the codebase or run heavy searches unless information is missing from the skill files.

## Technical & Architectural Rules

*   **Laravel Monolith**: The project is a pure Laravel monolith. Do not introduce decoupled SPA architecture.
*   **Blade Templates**: Use Blade for the public website and admin CMS UI.
*   **Custom Styling**: Use custom CSS in the public/admin folders. Do not add Tailwind, Bootstrap, shadcn, or style libraries unless explicitly requested.
*   **Javascript**: Keep JS simple (plain Vanilla JS or lightweight Alpine.js if needed). Do not install React, Vue, Svelte, or complex JS bundlers/frameworks.
*   **No Duplicate Abstractions**: Do not create new Services, Actions, Controllers, Models, or Blade components if equivalent objects already exist. Reuse existing handlers.
*   **Smallest Safe Change**: Keep modifications localized and minimal. Keep the code simple and easy to maintain.
*   **Documentation Maintenance**: Only update these `.ai-skills` files when database structures, route paths, conventions, or model relations are modified.
