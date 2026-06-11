<?php

namespace App\Http\Controllers\Admin;

use App\Actions\Media\DeleteMedia;
use App\Actions\Media\UploadMedia;
use App\Http\Controllers\Controller;
use App\Models\Media;
use Illuminate\Http\Request;

class MediaController extends Controller
{
    public function index(Request $request)
    {
        $query = Media::latest();

        if ($request->filled('folder') && $request->folder !== 'All') {
            $query->where('folder', $request->folder);
        }

        if ($request->filled('search')) {
            $query->where('file_name', 'like', '%' . $request->search . '%');
        }

        $files = $query->paginate(24)->withQueryString();
        $folders = ['All', 'articles', 'profiles', 'events', 'branding'];

        return view('admin.media.index', compact('files', 'folders'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'files.*' => 'required|image|mimes:jpeg,png,gif,webp|max:10240',
            'folder' => 'nullable|string',
        ]);

        $uploaded = [];
        $folder = $request->input('folder', 'articles');

        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $media = (new UploadMedia())->handle($file, auth()->user(), $folder);
                $uploaded[] = [
                    'id' => $media->id,
                    'name' => $media->file_name,
                    'url' => $media->file_url,
                ];
            }
        }

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json(['success' => true, 'uploaded' => $uploaded]);
        }

        return redirect()->route('admin.media.index')->with('success', 'Files uploaded successfully.');
    }

    public function show(string $id)
    {
        $media = Media::findOrFail($id);
        return response()->json($media);
    }

    public function destroy(string $id)
    {
        $media = Media::findOrFail($id);

        try {
            (new DeleteMedia())->handle($media);
            
            if (request()->wantsJson() || request()->ajax()) {
                return response()->json(['success' => true, 'message' => 'Media deleted successfully.']);
            }

            return redirect()->route('admin.media.index')->with('success', 'Media deleted successfully.');
        } catch (\Exception $e) {
            if (request()->wantsJson() || request()->ajax()) {
                return response()->json(['success' => false, 'message' => $e->getMessage()], 422);
            }

            return redirect()->route('admin.media.index')->with('error', $e->getMessage());
        }
    }
}
