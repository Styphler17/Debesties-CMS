# Posts Workflow

*   **Workflow Actions**: Located in `app/Actions/Posts/`. Single-task action classes handle the execution logic:
    *   `CreatePost`: Handles writing initial title, slug, and draft body.
    *   `UpdatePost`: Processes edits to post text, fields, and categorization.
    *   `DeletePost`: Performs soft delete or hard delete cleanup.
    *   `PublishPost`: Triggers active visibility, setting `status = 'published'` and `published_at = now()`.
    *   `SchedulePost`: Sets `status = 'scheduled'` and assigns `scheduled_for` timestamp.
*   **Workflow Services**:
    *   `PostService` (`app/Services/PostService.php`): Serves as the high-level class invoked by the controllers to coordinate actions, events, and jobs.
*   **Asynchronous Queued Jobs**:
    *   `PublishScheduledPost` (`app/Jobs/PublishScheduledPost.php`): Periodic scheduler queue handler that publishes posts whose `scheduled_for` timestamp has passed.
*   **Related Metadata Models**:
    *   `PostMeta`: Stores SEO tags, focus keywords, canonical URLs, and OG tags.
    *   `PostFaq`: Houses structured FAQ lists (question, answer, order).
    *   `PostSource`: Tracks reference URLs, credits, and citations.
    *   `PostRelated`: Pivot mapping self-referential links to other posts.
    *   `PostInternalLink`: Stores anchor texts and targets for internal link recommendations.
*   **Status Transitions Enum**:
    *   `status` transitions: `draft` -> `review` -> `approved` -> `scheduled` (optional) -> `published` -> `archived`.
