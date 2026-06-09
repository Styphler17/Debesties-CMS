# Skill Selector & Picker Guide

Welcome! Use this guide to identify the best local (project-specific) and global (system-wide) skill files to handle your current task. Always match the task category to the corresponding skill.

---

## 📂 1. Local Project-Specific Skills (`.ai-skills/`)
These files define the exact rules, folder paths, and stack constraints for the Debesties CMS codebase. **Read these first before making any changes.**

| Task / Job Category | Use Local Skill Document |
| :--- | :--- |
| **Monolith Architecture & Directory Layout** | [`architecture.md`](file:///.ai-skills/architecture.md) |
| **Artisan Routes, Web & Admin Route Definitions** | [`routes.md`](file:///.ai-skills/routes.md) |
| **Eloquent Models, Scopes, Relations & Casts** | [`models.md`](file:///.ai-skills/models.md) |
| **Migrations, Schema Structure & Table Definitions** | [`database.md`](file:///.ai-skills/database.md) |
| **Public Frontend Layouts, Assets & Custom CSS** | [`public-frontend.md`](file:///.ai-skills/public-frontend.md) |
| **Admin Dashboard UI, Components & Layouts** | [`admin-cms.md`](file:///.ai-skills/admin-cms.md) |
| **Posts Workflow (Create, Edit, Schedule, Publish)** | [`posts-workflow.md`](file:///.ai-skills/posts-workflow.md) |
| **Media Library Uploads, Variants & Storage** | [`media-library.md`](file:///.ai-skills/media-library.md) |
| **SEO Fields, OpenGraph & Search Crawler Visibility** | [`seo-ai-visibility.md`](file:///.ai-skills/seo-ai-visibility.md) |
| **RBAC Roles, Permissions & Policies** | [`users-roles-permissions.md`](file:///.ai-skills/users-roles-permissions.md) |
| **Dynamic Menus, Settings & Homepage Layout Builder** | [`settings-menus-homepage.md`](file:///.ai-skills/settings-menus-homepage.md) |
| **Deployment Scripts & Hostinger Target Setup** | [`deployment.md`](file:///.ai-skills/deployment.md) |
| **Core Coding Style & Dependency Boundaries** | [`coding-rules.md`](file:///.ai-skills/coding-rules.md) |
| **Execution Steps (Before, During, & After checklist)** | [`task-checklist.md`](file:///.ai-skills/task-checklist.md) |

---

## 🌍 2. Global Developer Skills (`C:\Users\styph\.gemini\skills\`)
These global skills are available to the AI assistant. Select the appropriate global skill to supplement your domain knowledge:

### 💻 Backend & Core Logic
*   **Artisan Commands, Service Providers, & Eloquent Queries**: Use `laravel-expert`.
*   **Security Vulnerabilities & Hardening Backend Code**: Use `laravel-security-audit`.
*   **SQL Schema Optimization & Database Queries**: Use `postgres-best-practices` or `postgresql`.
*   **Debugging Slow SQL Queries & Database Indexing**: Use `sql-optimization`.

### 🎨 Visual & UI Design
*   **UI/UX Layouts, Colors, Glassmorphism, & Visual Excellence**: Use `antigravity-design-expert` or `frontend-design`.
*   **Premium Scroll Effects, Animations & Transitions**: Use `scroll-experience` or `animejs-animation`.
*   **Mobile-First Responsive Layouts & Tap Target Styling**: Use `mobile-design`.

### 🚀 QA, Testing & Automation
*   **Writing & Debugging End-to-End Tests**: Use `browser-automation` or `e2e-testing-patterns`.
*   **Playwright Test Setup & Page Actions**: Use `playwright-skill` or `webapp-testing`.
*   **Scalability & Load Testing**: Use `k6-load-testing`.
*   **Troubleshooting General Code Errors**: Use `systematic-debugging` or `test-fixing`.
*   **Automated Pull Request Code Review & Quality Checks**: Use `code-reviewer`.

### 🛠️ Workflows & General Code Health
*   **Writing High-Quality Conventional Git Commits**: Use `commit` or `git-pushing`.
*   **General Code Quality & Automated Linting**: Use `lint-and-validate` or `clean-code`.
*   **Planning Architecture & Formulating Implementation Steps**: Use `concise-planning`.
*   **Technical SEO Audit & Page Performance Checks**: Use `seo-audit` or `seo-fundamentals`.
*   **Removing AI Writing Traces, Polishing Tone, & Naturalizing Text**: Use `humanizer`.
