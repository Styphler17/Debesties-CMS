# Blade Surgical Refactor Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Resolve "',' expected" editor validation errors by adding CSS font fallbacks, moving Blade logic out of `style` attributes, and cleaning up SVG attributes.

**Architecture:** Use `@php` blocks to build style strings as variables and apply font fallbacks consistently.

**Tech Stack:** PHP, Laravel Blade, CSS.

---

### Task 1: Add Font Fallbacks

**Files:**
- All `.blade.php` files in `resources/views/admin/`

- [ ] **Step 1: Replace UI font variables**
Run: `powershell.exe -NoProfile -Command "Get-ChildItem resources/views/admin/ -Filter *.blade.php -Recurse | ForEach-Object { (Get-Content $_.FullName) -replace 'var\(--cms-font-ui\)', 'var(--cms-font-ui), sans-serif' | Set-Content $_.FullName }"`

- [ ] **Step 2: Replace Display font variables**
Run: `powershell.exe -NoProfile -Command "Get-ChildItem resources/views/admin/ -Filter *.blade.php -Recurse | ForEach-Object { (Get-Content $_.FullName) -replace 'var\(--cms-font-disp\)', 'var(--cms-font-disp), serif' | Set-Content $_.FullName }"`

- [ ] **Step 3: Replace Mono font variables**
Run: `powershell.exe -NoProfile -Command "Get-ChildItem resources/views/admin/ -Filter *.blade.php -Recurse | ForEach-Object { (Get-Content $_.FullName) -replace 'var\(--cms-font-mono\)', 'var(--cms-font-mono), monospace' | Set-Content $_.FullName }"`

### Task 2: Refactor `style` attributes with inline logic

**Files:**
- `resources/views/admin/ai-visibility/index.blade.php`
- `resources/views/admin/dashboard/index.blade.php`
- `resources/views/admin/seo/index.blade.php`

- [ ] **Step 1: Refactor ai-visibility index**
Move `--score: {{ $visibilityScore['score'] }}; stroke-dasharray: var(--score), 100;` to `@php` block.

- [ ] **Step 2: Refactor dashboard index**
Refactor lines 277 and 307 where complex string concatenation is used inside `style`.

- [ ] **Step 3: Refactor seo index**
Refactor lines 145 and 242.

### Task 3: Final Sweep and Verification

- [ ] **Step 1: Grep check for missed `font-family`**
Run: `grep -r "font-family:" resources/views/admin/ | grep -v "sans-serif" | grep -v "serif" | grep -v "monospace"`

- [ ] **Step 2: Grep check for inline logic in style**
Run: `grep -r "style=\".*{{.*}}.*\"" resources/views/admin/`

- [ ] **Step 3: Verify no syntax errors introduced**
Run: `php artisan view:cache`
