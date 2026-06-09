# Task Checklist

Please complete this checklist during every coding task execution:

## Before Coding

*   [ ] Read `.ai-skills/project-overview.md` to align on target goals and stack constraints.
*   [ ] Read `.ai-skills/architecture.md` to map directories and patterns.
*   [ ] Read the specific `.ai-skills/` document related to your current task.
*   [ ] Scan only the exact files needed to perform the change.
*   [ ] Verify the existing pattern used in the target files before editing.

## While Coding

*   [ ] Make the smallest safe change.
*   [ ] Reuse existing models, services, actions, views, and helpers. Do not write duplicate structures.
*   [ ] Avoid adding new composer or npm package dependencies.
*   [ ] Avoid performing unrelated refactoring or code cleanup.

## After Coding

*   [ ] Validate routes configuration using `php artisan route:list`.
*   [ ] Verify Blade view compilation is error-free.
*   [ ] Check database model mappings and relations if migrations/models were touched.
*   [ ] Check request validation rules.
*   [ ] Verify authorization policies allow the targeted actions.
*   [ ] Update the corresponding `.ai-skills` documentation file **only** if naming conventions, database schemas, or routing paths were changed.
