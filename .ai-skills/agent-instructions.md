# Agent Instructions

Welcome, future coding agent! Please follow these guidelines strictly when working in this codebase:

## Step-by-Step Task Reading

1.  **First**: Read [`skill-picker.md`](file:///.ai-skills/skill-picker.md) to identify the best local and global skills for your current job.
2.  **Second**: Read [`project-overview.md`](file:///.ai-skills/project-overview.md) and [`architecture.md`](file:///.ai-skills/architecture.md) to align on target goals, stack, and codebase structure.
3.  **Third**: Read the specific local skill files identified by `skill-picker.md` (e.g., `media-library.md` for uploading tasks) or activate the corresponding global skill (e.g. `laravel-expert` for backend queries).
4.  **Avoid Full Code Scanning**: Do not recursively search the codebase or run heavy searches unless information is missing from the skill files.

## Technical & Architectural Rules

*   **Laravel Monolith**: The project is a pure Laravel monolith. Do not introduce decoupled SPA architecture.
*   **Blade Templates**: Use Blade for the public website and admin CMS UI.
*   **Custom Styling**: Use custom CSS in the public/admin folders. Do not add Tailwind, Bootstrap, shadcn, or style libraries unless explicitly requested.
*   **Javascript**: Keep JS simple (plain Vanilla JS or lightweight Alpine.js if needed). Do not install React, Vue, Svelte, or complex JS bundlers/frameworks.
*   **No Duplicate Abstractions**: Do not create new Services, Actions, Controllers, Models, or Blade components if equivalent objects already exist. Reuse existing handlers.
*   **Smallest Safe Change**: Keep modifications localized and minimal. Keep the code simple and easy to maintain.
*   **Documentation Maintenance**: Only update these `.ai-skills` files when database structures, route paths, conventions, or model relations are modified.
