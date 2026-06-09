# Skill Selector & Picker Guide

Use this guide to identify the best local (project-specific) and global (system-wide) skill files for your current task. Always read the relevant local `.ai-skills/` document **before** touching code — see `task-checklist.md`.

---

## 📂 1. Local Project-Specific Skills (`.ai-skills/`)
These define the exact rules, folder paths, and stack constraints for the Debesties CMS codebase. **Read these first.**

| Task / Job Category | Use Local Skill Document |
| :--- | :--- |
| **Monolith Architecture & Directory Layout** | [`architecture.md`](.ai-skills/architecture.md) |
| **Artisan Routes, Web & Admin Route Definitions** | [`routes.md`](.ai-skills/routes.md) |
| **Eloquent Models, Scopes, Relations & Casts** | [`models.md`](.ai-skills/models.md) |
| **Migrations, Schema Structure & Table Definitions** | [`database.md`](.ai-skills/database.md) |
| **Public Frontend Layouts, Assets & Custom CSS** | [`public-frontend.md`](.ai-skills/public-frontend.md) |
| **Admin Dashboard UI, Built Views & Layouts** | [`admin-cms.md`](.ai-skills/admin-cms.md) |
| **Posts Workflow (Create, Edit, Schedule, Publish)** | [`posts-workflow.md`](.ai-skills/posts-workflow.md) |
| **Media Library Uploads, Variants & Storage** | [`media-library.md`](.ai-skills/media-library.md) |
| **SEO Fields, OpenGraph & Search Crawler Visibility** | [`seo-ai-visibility.md`](.ai-skills/seo-ai-visibility.md) |
| **RBAC Roles, Permissions & Policies** | [`users-roles-permissions.md`](.ai-skills/users-roles-permissions.md) |
| **Dynamic Menus, Settings & Homepage Layout Builder** | [`settings-menus-homepage.md`](.ai-skills/settings-menus-homepage.md) |
| **Deployment Scripts & Hostinger Target Setup** | [`deployment.md`](.ai-skills/deployment.md) |
| **Core Coding Style & Dependency Boundaries** | [`coding-rules.md`](.ai-skills/coding-rules.md) |
| **Execution Steps (Before, During, & After checklist)** | [`task-checklist.md`](.ai-skills/task-checklist.md) |

---

## 🔧 2. Project-Local Agent Skills (`.agents/skills/`)
Installed in this repo via `npx skills add obra/superpowers`. Used to control *how* coding tasks are approached.

| Skill | When to Use |
| :--- | :--- |
| `brainstorming` | Before creating any new feature, component, or behavior — explore requirements first |
| `dispatching-parallel-agents` | 2+ independent tasks that can run simultaneously (e.g. build categories + tags views at once) |
| `executing-plans` | Running a written implementation plan in a separate session with checkpoints |
| `finishing-a-development-branch` | When implementation is done — PR prep, cleanup, merge decision |
| `frontend-design` | UI/UX aesthetic direction, typography choices, premium design patterns |
| `receiving-code-review` | Before implementing review feedback — verify it's technically sound first |
| `requesting-code-review` | After completing a feature — structure the review request clearly |
| `subagent-driven-development` | Delegate independent subtasks to specialized subagents in current session |
| `systematic-debugging` | Any bug, test failure, or unexpected behavior — before proposing fixes |
| `test-driven-development` | Implementing any feature or bugfix — write tests first |
| `using-git-worktrees` | Starting feature work needing branch isolation |
| `using-superpowers` | Core superpowers orchestration — start here to find the right skill |
| `verification-before-completion` | Before claiming work is done — run verification commands, show evidence |
| `writing-plans` | When given a spec/requirements — write the plan before touching code |
| `writing-skills` | Creating or editing skill files |

---

## 🌍 3. Global Developer Skills (`C:\Users\styph\.gemini\skills\`)
Available system-wide across all projects.

### 🗣️ Communication & Style
| Skill | When to Use |
| :--- | :--- |
| `caveman` *(global: `~\.agents\skills\`)* | Ultra-compressed replies, ~75% fewer tokens. Activate: "caveman mode". Off: "normal mode" |
| `humanizer` | Remove AI writing traces, polish tone, naturalize text |
| `agents-md` | Create/update/audit `AGENTS.md` or `CLAUDE.md` instructions |

### 💻 Backend & Laravel
| Skill | When to Use |
| :--- | :--- |
| `laravel-expert` | Artisan commands, Service Providers, Eloquent queries |
| `laravel-security-audit` | Security vulnerabilities & backend hardening |
| `php-pro` | General PHP patterns and best practices |
| `sql-optimization` | Debugging slow queries & DB indexing |
| `postgres-best-practices` / `postgresql` | SQL schema optimization & complex queries |

### 🎨 Visual & UI Design
| Skill | When to Use |
| :--- | :--- |
| `antigravity-design-expert` / `frontend-design` | UI/UX layouts, colors, glassmorphism, visual excellence |
| `scroll-experience` / `animejs-animation` | Premium scroll effects, animations & transitions |
| `mobile-design` | Mobile-first responsive layouts & tap targets |
| `high-end-visual-design` | Premium/luxury aesthetics |
| `accessibility-compliance-accessibility-audit` | WCAG audits & inclusive UI checks |

### 🚀 QA, Testing & Debugging
| Skill | When to Use |
| :--- | :--- |
| `systematic-debugging` / `debugging-strategies` | Troubleshooting general code errors methodically |
| `browser-automation` / `playwright-skill` | E2E testing & browser automation |
| `k6-load-testing` | Scalability & load testing |
| `code-reviewer` | Automated PR quality checks |

### 🛠️ Workflows & Code Health
| Skill | When to Use |
| :--- | :--- |
| `commit` / `git-pushing` | High-quality conventional git commits |
| `lint-and-validate` / `clean-code` | Code quality & automated linting |
| `concise-planning` | Architecture planning & implementation steps |
| `seo-audit` / `ai-seo` | Technical SEO audit & performance checks |
| `code-review-excellence` | Deep code review patterns |
