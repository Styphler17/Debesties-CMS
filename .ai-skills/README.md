# .ai-skills Directory

This folder contains lightweight, project-specific documentation and specifications ("skills") for AI coding agents. Reading these files first helps future agents understand the project context, naming conventions, and architecture without repeatedly scanning the full codebase.

## Files and Content Directory

*   **[agent-instructions.md](file:///.ai-skills/agent-instructions.md)**: Entry point for AI agents. Guidelines on where to start and what libraries/architectures to avoid.
*   **[skill-picker.md](file:///.ai-skills/skill-picker.md)**: Guide for picking the best local or global skill for any coding job.
*   **[project-overview.md](file:///.ai-skills/project-overview.md)**: High-level overview of Debesties CMS, the target audience, technology stack, and CMS modules.
*   **[architecture.md](file:///.ai-skills/architecture.md)**: Directory structure layout and organization of Controllers, Models, Services, and Actions.
*   **[routes.md](file:///.ai-skills/routes.md)**: List of confirmed web and admin route definitions and naming conventions.
*   **[database.md](file:///.ai-skills/database.md)**: Database schema layout, table definitions, and migrations ordering.
*   **[models.md](file:///.ai-skills/models.md)**: Eloquent models list, casts, fillable/guarded properties, and relationship mappings.
*   **[public-frontend.md](file:///.ai-skills/public-frontend.md)**: Specs for the public-facing blog website, Blade views, assets, and styling rules.
*   **[admin-cms.md](file:///.ai-skills/admin-cms.md)**: Configuration of the admin dashboard UI kit, layout components, and sections.
*   **[posts-workflow.md](file:///.ai-skills/posts-workflow.md)**: Step-by-step description of article creation, editing, scheduling, and deletion workflows.
*   **[media-library.md](file:///.ai-skills/media-library.md)**: Workflows for uploading files, optimizing image variants, and storage configurations.
*   **[seo-ai-visibility.md](file:///.ai-skills/seo-ai-visibility.md)**: SEO features, slug generation, sitemap building, and AI crawler visibility settings.
*   **[users-roles-permissions.md](file:///.ai-skills/users-roles-permissions.md)**: RBAC structure, roles, permissions seeders, and access policies.
*   **[settings-menus-homepage.md](file:///.ai-skills/settings-menus-homepage.md)**: Dynamic menus, settings management, and layout builder configurations.
*   **[coding-rules.md](file:///.ai-skills/coding-rules.md)**: Code formatting rules, architectural boundaries, and package constraints.
*   **[deployment.md](file:///.ai-skills/deployment.md)**: Hostinger shared/cloud target constraints, optimization scripts, and env setup.
*   **[task-checklist.md](file:///.ai-skills/task-checklist.md)**: Step-by-step checklist to follow before, during, and after executing coding tasks.

## How to use this folder

1.  **Do not scan the full codebase**: Read `agent-instructions.md` first, then locate the specific file matching your current task.
2.  **Verify before editing**: Always cross-reference the facts listed in these files with the actual codebase files to ensure they are up to date.
3.  **Keep it lightweight**: Only update these files when routes, schema, or structural patterns change.
