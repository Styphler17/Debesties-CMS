# SEO & AI Visibility

*   **Services**:
    *   `SeoService` (`app/Services/SeoService.php`): Coordinates sitemap generation, structured schema building, keyword tracking, and readability analysis.
    *   `AiVisibilityService` (`app/Services/AiVisibilityService.php`): Controls sitemaps for LLM search crawlers, templates XML instructions, manages robots.txt visibility permissions, and outputs machine-readable content structures.
*   **Actions**:
    *   `GenerateSlug` (`app/Actions/SEO/GenerateSlug.php`): URL-friendly slug generator. Standard behavior utilizes `Str::slug()` with uniqueness validation checks.
    *   `BuildMetaData` (`app/Actions/SEO/BuildMetaData.php`): Aggregates SEO titles, keywords, canonical URLs, and OG tags into layout views.
    *   `SuggestInternalLinks` (`app/Actions/SEO/SuggestInternalLinks.php`): Scans content paragraphs to recommend internal links matching keyword anchors.
*   **Database Models**:
    *   `PostMeta`: Stores SEO, og tags, and canonical fields.
    *   `PostFaq`: Maps question-answers for schema building.
    *   `PostSource`: Links bibliography references.
    *   `PostInternalLink`: Stores anchors and internal references.
*   **Sitemap & Schema**:
    *   `SitemapController` handles XML sitemap output (Not confirmed).
    *   Schema output behavior (JSON-LD templates) is not yet fully configured in the class stubs (Not confirmed).
