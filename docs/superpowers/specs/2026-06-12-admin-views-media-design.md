# Admin Dashboard Views & Media Library Design

**Date:** 2026-06-12
**Status:** Approved

Implement the backend logic and frontend wiring for the Admin CMS Media Library and Posts List search/filtering/deletion.

---

## 1. Media Pipeline Architecture

### Models & Database
- `Media` model stores file details (`file_name`, `file_path`, `file_url`, `mime_type`, `file_size`, `alt_text`, `caption`, `title`, `folder`, `width`, `height`, `user_id`).
- Migration `0001_01_01_000070_create_media_table.php` has been updated to remove soft deletes.
- Storage disk is the local public disk (`storage/app/public/`).

### Actions & Jobs

#### `UploadMedia` Action (`app/Actions/Media/UploadMedia.php`)
- Validates the uploaded file is an image (JPEG, PNG, GIF, WEBP) under 10MB.
- Generates a unique UUID filename: `{uuid}.{ext}`.
- Saves the original file to `uploads/originals/` directory on the public disk.
- Extracts width and height dimensions of the original image.
- Saves record to the `media` table.
- Dispatches `OptimizeMedia` job with the media ID.
- Returns the `Media` model instance.

#### `OptimizeMedia` Job (`app/Jobs/OptimizeMedia.php`)
- Uses PHP GD extension to generate three variants:
  - `thumb`: 300x200 crop
  - `medium`: 800px proportional width
  - `large`: 1200px proportional width
- Saves variants in `uploads/thumb/`, `uploads/medium/`, and `uploads/large/`.

#### `DeleteMedia` Action (`app/Actions/Media/DeleteMedia.php`)
- Guards deletion if the media ID is referenced by `posts.featured_image_id`.
- Deletes the original file and all three variant files from storage.
- Deletes the `Media` record from the database.

---

## 2. Media Library Views & Controller

### `MediaController` (`app/Http/Controllers/Admin/MediaController.php`)
- **`index`:** Retrieves paginated media library uploads from the database (`Media::latest()->paginate(24)`). Filters by folder category if requested.
- **`store`:** Validates input files, loops and calls `UploadMedia` action, returning JSON metadata for the uploaded files.
- **`destroy`:** Invokes `DeleteMedia` action. Returns JSON response (or redirect with flash message).

### View Wiring (`resources/views/admin/media/index.blade.php`)
- Replaces the hardcoded `$files` array with paginated `$files` passed from the controller.
- Wires the file upload input and drop zone to post to the `store` endpoint.
- Corrects the edit alt/caption form to save metadata changes.

---

## 3. Posts List Wiring

### `PostController` (`app/Http/Controllers/Admin/PostController.php`)
- **`index`:** Supports search query parameter `q` matching `posts.title` and `posts.body`. Supports `category_id` and `user_id` filters.
- Wires sorting logic.

### View Wiring (`resources/views/admin/posts/index.blade.php`)
- Wires search input and filters to submit via GET parameters to the route.
- Replaces dummy delete logic in JS with a form submission that submits a POST request with `_method="DELETE"` to the `destroy` route of the post.
