---
name: frontend-expert
description: Use when creating or editing the Debesties CMS public frontend, admin Blade views, custom CSS, JavaScript interactions, responsive layouts, SEO-friendly article pages, CMS dashboard UI, forms, tables, cards, media UI, and editorial workflow screens. This project is a Laravel monolith using Blade, custom CSS, MariaDB, and small JavaScript interactions. Do not use React, Vue, Tailwind, MUI, shadcn, Lucide, TanStack Router, or SPA patterns unless explicitly requested.
---

# Frontend Expert

Frontend rules for the Debesties CMS Laravel monolith.

This skill is for building fast, clean, responsive Blade interfaces for:

* Public Debesties.com website
* Admin CMS dashboard
* Article pages
* Category/tag/author/search pages
* Post editor
* Media library
* SEO and AI visibility panels
* Settings, menus, users, roles, comments, analytics, and homepage builder screens

## Core Stack

* Laravel monolith
* Blade templates
* Custom CSS
* Small JavaScript only where needed
* MariaDB-backed CMS
* Hostinger shared/cloud hosting target
* Public frontend and admin dashboard live in the same Laravel app

## Critical Rules

* Do not use React.
* Do not use Vue.
* Do not use Tailwind unless already installed and explicitly approved.
* Do not use MUI.
* Do not use shadcn.
* Do not use Lucide unless already installed and explicitly approved.
* Do not create SPA routing.
* Do not create frontend/backend separation.
* Do not add unnecessary dependencies.
* Keep Blade views simple and readable.
* Keep CSS custom, organized, and reusable.
* Keep JavaScript small and page-specific.
* Prefer existing layouts, components, and CSS patterns.
* Do not duplicate components or styles.
* Make the smallest safe UI change.

## Project Structure

Use this structure.

```text
resources/
├── views/
│   ├── public/
│   │   ├── home.blade.php
│   │   ├── article.blade.php
│   │   ├── category.blade.php
│   │   ├── tag.blade.php
│   │   ├── author.blade.php
│   │   └── search.blade.php
│   └── admin/
│       ├── dashboard/
│       ├── posts/
│       ├── categories/
│       ├── tags/
│       ├── media/
│       ├── calendar/
│       ├── analytics/
│       ├── seo/
│       ├── ai-visibility/
│       ├── users/
│       ├── roles/
│       ├── comments/
│       ├── settings/
│       ├── menus/
│       └── homepage-builder/
├── css/
└── js/
```

## Blade View Rules

* Use Blade layouts for repeated page structure.
* Use Blade components for repeated UI blocks.
* Keep page views focused on layout.
* Keep business logic out of Blade.
* Do not write database queries inside Blade.
* Use escaped output with `{{ }}` by default.
* Use `{!! !!}` only for trusted, sanitized article HTML from the CMS editor.
* Avoid deeply nested Blade conditionals.
* Use partials/components for repeated sections.

## Public Frontend Rules

Public pages must be:

* Fast
* Mobile-first
* SEO-friendly
* Clean and readable
* Optimized for article discovery
* Optimized for Google Search, Google Discover, ChatGPT, Gemini, Claude, and Perplexity

Important public pages:

* Homepage
* Article page
* Category page
* Tag page
* Author page
* Search page

## Public Homepage Requirements

The homepage should support:

* Breaking/trending bar
* Main hero story
* Secondary story cards
* Latest posts grid
* Category sections
* Featured guides/explainers
* Newsletter block
* Clean footer
* Mobile navigation
* Search access

Keep the homepage modular so sections can later be controlled by the homepage builder.

## Article Page Requirements

Article pages should support:

* Category label
* Headline
* Subtitle/deck
* Author info
* Published date
* Updated date
* Featured image
* Quick Answer block
* Key Facts block
* Table of contents when useful
* Article body
* FAQ section
* Sources section
* Related posts
* Author bio card
* Social share buttons
* Clean mobile reading layout

Use readable article typography. Avoid clutter.

## Category, Tag, Author, and Search Pages

Category pages should include:

* Category title
* SEO intro
* Featured article
* Post grid/list
* Pagination or load more
* Optional bottom SEO text

Tag pages should include:

* Tag title
* Short description if available
* Related posts

Author pages should include:

* Author name
* Bio
* Expertise
* Social links if available
* Author posts

Search pages should include:

* Search input
* Result cards
* Empty state
* Optional filters if already supported

## Admin CMS Rules

Admin pages must be:

* Clean
* Fast
* Practical
* Easy for non-technical editors
* Consistent across modules
* Not styled like WordPress admin
* Not styled like a generic SaaS dashboard

Admin modules:

* Dashboard
* Posts
* Categories
* Tags
* Media
* Calendar
* Analytics
* SEO
* AI Visibility
* Users
* Roles
* Comments
* Settings
* Menus
* Homepage Builder

## Admin Layout Requirements

Use consistent admin UI patterns:

* Sidebar navigation
* Top bar
* Page header
* Action buttons
* Cards
* Data tables
* Filters
* Status badges
* Forms
* Modals only when needed
* Empty states
* Confirmation states
* Toast/flash messages

## Posts UI Requirements

Posts list should support:

* Search
* Status filter
* Category filter
* Author filter
* Date filter
* Bulk actions if implemented
* Featured image thumbnail
* Title
* Author
* Category
* Status
* Published/updated date
* SEO score if implemented
* Views if implemented
* Row actions

Post editor should support:

* Title
* Slug
* Subtitle/deck
* Category
* Tags
* Featured image
* Article body
* Quick Answer
* Key Facts
* FAQ builder
* Sources builder
* Related posts
* Internal links
* SEO title
* Meta description
* Focus keyword
* Search intent
* Schema type
* Open Graph fields
* Draft/review/schedule/publish actions

## SEO and AI Visibility UI

SEO and AI visibility screens should be direct and useful.

Support UI for:

* Focus keyword
* Search intent
* SEO title
* Meta description
* Slug
* Canonical URL
* Schema type
* FAQ blocks
* Source links
* Internal link suggestions
* Direct answer
* Entity summary
* Content freshness
* Last updated date
* Search preview
* Social preview

Do not create fake SEO scores unless the backend supports them.

## Media Library UI

Media screens should support:

* Upload area
* Grid view
* List view if implemented
* Image preview
* Alt text
* Caption
* Credit/source
* File path
* File size
* Dimensions if available
* Used-in-posts info if available
* Delete confirmation

Use optimized image display. Do not load full-size images in grid thumbnails.

## CSS Rules

Use custom CSS.

Recommended organization:

```text
resources/css/
├── app.css
├── public.css
├── admin.css
├── components.css
└── utilities.css
```

Only create these files if the project already follows or needs this structure.

CSS rules:

* Use clear class names.
* Prefer reusable classes for cards, buttons, forms, badges, grids, and tables.
* Avoid inline styles.
* Avoid over-specific selectors.
* Avoid large duplicated blocks.
* Use CSS variables for colors, spacing, radius, shadows, and typography.
* Keep mobile-first styles.
* Use media queries for tablet and desktop.
* Keep animations subtle.
* Do not add heavy animation libraries.

Suggested CSS variables:

```css
:root {
    --color-bg: #f8f5ef;
    --color-surface: #ffffff;
    --color-text: #171717;
    --color-muted: #6b7280;
    --color-border: #e5e7eb;
    --color-gold: #d6a429;
    --color-green: #16784f;
    --color-red: #b42318;
    --color-dark: #111111;

    --radius-sm: 6px;
    --radius-md: 10px;
    --radius-lg: 16px;

    --shadow-sm: 0 1px 2px rgba(0, 0, 0, .06);
    --shadow-md: 0 8px 24px rgba(0, 0, 0, .08);
}
```

## JavaScript Rules

Use JavaScript only for interactions that need it.

Good uses:

* Mobile menu toggle
* Dropdowns
* Tabs
* Modals
* Slug preview
* SEO preview
* Image preview
* Confirm delete
* Character counters
* Simple editor helpers

Bad uses:

* Rebuilding pages as SPA
* Replacing Blade rendering
* Complex state management
* Heavy frontend framework behavior

Recommended structure:

```text
resources/js/
├── app.js
├── public/
│   ├── navigation.js
│   ├── search.js
│   └── article.js
└── admin/
    ├── dashboard.js
    ├── editor.js
    ├── media-library.js
    ├── slug-generator.js
    └── seo-preview.js
```

Only create files that are needed.

## Responsive Rules

Every screen must work on:

* Mobile
* Tablet
* Desktop

Mobile rules:

* Navigation must be easy to use.
* Article text must be readable.
* Tables should become stacked cards or horizontally scroll safely.
* Admin forms should use single-column layout.
* Sidebar should collapse or become drawer navigation.
* Buttons must be large enough to tap.

## Accessibility Rules

* Use semantic HTML.
* Use proper labels for forms.
* Use buttons for actions.
* Use links for navigation.
* Add alt text for meaningful images.
* Do not rely only on color for status.
* Keep focus states visible.
* Use readable contrast.
* Use correct heading order.

## Performance Rules

* Keep Blade pages server-rendered.
* Avoid unnecessary JavaScript.
* Avoid loading large images directly.
* Use thumbnail variants where available.
* Lazy-load below-the-fold images.
* Avoid large CSS duplication.
* Avoid heavy third-party scripts.
* Keep admin pages practical and lightweight.

## Form Rules

* Use existing Laravel Form Request validation patterns when available.
* Show field errors near fields.
* Preserve old input after validation errors.
* Use clear labels.
* Use helpful placeholders only when needed.
* Do not hide important fields behind confusing UI.
* Use confirmation for destructive actions.

Example field pattern:

```blade
<label for="title" class="form-label">Title</label>
<input
    id="title"
    name="title"
    type="text"
    class="form-input"
    value="{{ old('title', $post->title ?? '') }}"
>
@error('title')
    <p class="form-error">{{ $message }}</p>
@enderror
```

## Table Rules

Admin tables should include:

* Clear column names
* Empty state
* Pagination if needed
* Filters if useful
* Action buttons grouped cleanly
* Status badges
* Responsive behavior

Do not overload tables with too many columns.

## Button Rules

Use consistent button classes:

```text
.btn
.btn-primary
.btn-secondary
.btn-danger
.btn-ghost
.btn-sm
```

Button behavior:

* Primary: main action
* Secondary: alternative action
* Danger: destructive action
* Ghost: low-priority action

## Badge Rules

Use badges for:

* Draft
* Published
* Scheduled
* Needs Review
* Archived
* Active
* Inactive
* Approved
* Pending
* Rejected

Do not use badge colors without text labels.

## Empty State Rules

Every list page needs an empty state.

Empty state should include:

* Clear message
* Short explanation
* Main action button if relevant

Example:

```blade
<div class="empty-state">
    <h2>No posts yet</h2>
    <p>Create your first article for Debesties.</p>
    <a href="{{ route('admin.posts.create') }}" class="btn btn-primary">Create Post</a>
</div>
```

## Loading and Error States

For normal Laravel pages:

* Prefer server-rendered complete pages.
* Use flash messages after actions.
* Use validation errors for forms.
* Use small loading states only for JavaScript interactions.

Do not create React-style Suspense loading patterns.

## Blade Component Pattern

Use Blade components for repeated UI.

Examples:

```text
resources/views/components/admin/status-badge.blade.php
resources/views/components/admin/stat-card.blade.php
resources/views/components/public/article-card.blade.php
resources/views/components/public/breadcrumb.blade.php
```

Component rules:

* Keep components small.
* Pass simple props.
* Do not query database inside components.
* Reuse existing components before creating new ones.

## Public Article Card Example

```blade
<article class="article-card">
    <a href="{{ route('posts.show', $post->slug) }}" class="article-card__image-link">
        <img
            src="{{ $post->featuredImageUrl }}"
            alt="{{ $post->featured_image_alt ?? $post->title }}"
            class="article-card__image"
            loading="lazy"
        >
    </a>

    <div class="article-card__body">
        <p class="article-card__category">{{ $post->category->name ?? 'News' }}</p>

        <h2 class="article-card__title">
            <a href="{{ route('posts.show', $post->slug) }}">
                {{ $post->title }}
            </a>
        </h2>

        @if (!empty($post->excerpt))
            <p class="article-card__excerpt">{{ $post->excerpt }}</p>
        @endif
    </div>
</article>
```

## Admin Status Badge Example

```blade
<span class="status-badge status-badge--{{ $status }}">
    {{ ucfirst(str_replace('_', ' ', $status)) }}
</span>
```

## Before Editing UI

Read these files first:

```text
.ai-skills/project-overview.md
.ai-skills/architecture.md
.ai-skills/frontend.md or .ai-skills/public-frontend.md
.ai-skills/admin-cms.md if editing admin
```

Then inspect only the files needed for the task.

## Task Checklist

Before coding:

```markdown
- [ ] Confirm whether task is public frontend or admin CMS
- [ ] Read relevant .ai-skills files
- [ ] Check existing Blade layout/component pattern
- [ ] Check existing CSS naming pattern
- [ ] Check existing JS pattern if interaction is needed
- [ ] Identify smallest files to edit
```

While coding:

```markdown
- [ ] Use Blade
- [ ] Use custom CSS
- [ ] Keep JavaScript minimal
- [ ] Reuse existing components
- [ ] Avoid new dependencies
- [ ] Avoid SPA patterns
- [ ] Keep layout responsive
- [ ] Keep forms accessible
- [ ] Keep code readable
```

After coding:

```markdown
- [ ] Check mobile layout
- [ ] Check desktop layout
- [ ] Check validation errors if form exists
- [ ] Check empty states if list exists
- [ ] Check route names
- [ ] Check asset imports
- [ ] Remove unused classes/scripts
- [ ] Update related .ai-skills file only if structure or convention changed
```

## Do Not Use

Never apply these patterns unless explicitly requested:

```text
React.FC
useSuspenseQuery
React.lazy
SuspenseLoader
TanStack Router
MUI Grid
MUI sx
React Hook Form
Zod frontend validation
shadcn components
Lucide icons
Tailwind utility classes
SPA route folders
client-side app shell
```

## Core Principles

1. Laravel monolith first.
2. Blade first.
3. Custom CSS first.
4. Small JavaScript only when needed.
5. Public pages must be SEO-friendly.
6. Admin pages must be editor-friendly.
7. Reuse existing project patterns.
8. Keep Hostinger deployment simple.
9. Avoid unnecessary packages.
10. Make the smallest safe change.
