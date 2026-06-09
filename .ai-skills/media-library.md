# Media Library

*   **Actions**:
    *   `UploadMedia` (`app/Actions/Media/UploadMedia.php`): File upload processor. Saves raw files to storage, extracts metadata, and instantiates a `Media` database entry.
    *   `DeleteMedia` (`app/Actions/Media/DeleteMedia.php`): Removes file assets from disk and deletes database records.
    *   `GenerateImageVariants` (`app/Actions/Media/GenerateImageVariants.php`): Generates smaller, optimized image thumbnails and screen sizes (e.g. mobile, desktop card sizes).
*   **Services & Jobs**:
    *   `MediaService` (`app/Services/MediaService.php`): High-level uploader/organizer service.
    *   `OptimizeMedia` (`app/Jobs/OptimizeMedia.php`): Queue job to process heavy images asynchronously, compress files, and convert them to modern formats (e.g. WEBP) if tools are available.
*   **Upload Paths**:
    *   Standard upload path: `public/uploads/` (linked to `storage/app/public/` using Laravel's storage link structure).
*   **Storage / Public Strategy**:
    *   Files are uploaded under private directories and exposed via `php artisan storage:link` symlink mapping `public/storage` -> `storage/app/public`.
*   **Image Optimization Rules**:
    *   Not confirmed. Specific dimension scales, crop models, or compression packages (e.g. Intervention Image) are not yet fully configured in the class stubs.
