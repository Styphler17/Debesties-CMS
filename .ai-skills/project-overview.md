# Project Overview

*   **Project Name**: Debesties CMS
*   **Purpose**: Replaces WordPress as a lightweight, fast publishing platform for Debesties.com (targeting Ghana Music Awards coverage).
*   **Technology Stack**:
    *   Core: Laravel 11/13, PHP 8.3+
    *   Database: MySQL / MariaDB (default SQLite for local mock testing)
    *   Frontend: Blade Templates, custom CSS, simple JS
    *   Hosting: Hostinger shared/cloud hosting target
*   **Main CMS Modules**:
    *   Dashboard
    *   Posts (CRUD, Scheduling)
    *   Categories & Tags
    *   Media Library (Upload, Variants)
    *   Editorial Calendar
    *   Analytics
    *   SEO Tools
    *   AI Visibility & indexing controls
    *   Users, Roles, & Permissions
    *   Comments Moderation
    *   Menus & Homepage Layout Builder
*   **Public Website Modules**:
    *   Homepage
    *   Article Details
    *   Category Page
    *   Tag Page
    *   Author Profiles
    *   Search Engine Results
    *   Sitemap XML
*   **Confirmed Folders**:
    *   `app/Actions/` (Subfolders: `Posts/`, `Media/`, `SEO/`)
    *   `app/Http/Controllers/` (Subfolders: `Public/`, `Admin/`)
    *   `app/Http/Requests/` (Subfolders: `Public/`, `Admin/`)
    *   `app/Models/` (Eloquent Models)
    *   `app/Policies/` (Authorization Access Policies)
    *   `app/Services/` (Business logic layers)
    *   `app/Jobs/` (Queue jobs)
    *   `app/Observers/` (Model triggers)
    *   `database/migrations/`, `database/seeders/`, `database/factories/`
    *   `resources/views/public/`, `resources/views/admin/`
    *   `public/assets/`, `public/uploads/`
*   **Not Confirmed**:
    *   Hosting server shell access methods
    *   External Analytics APIs
    *   Spatie Laravel Permission package configuration (currently using custom RBAC migrations)
