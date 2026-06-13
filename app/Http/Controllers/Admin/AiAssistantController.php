<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Services\AiAssistantService;
use Illuminate\Http\Request;

class AiAssistantController extends Controller
{
    protected $aiService;

    public function __construct(AiAssistantService $aiService)
    {
        $this->aiService = $aiService;
    }

    public function generateTags(Request $request)
    {
        $this->authorize('create', Post::class);

        $request->validate([
            'title' => ['required', 'string'],
            'body' => ['required', 'string'],
        ]);

        $tags = $this->aiService->generateTags($request->title, $request->body);

        return response()->json([
            'success' => true,
            'tags' => $tags,
        ]);
    }

    public function generateOutline(Request $request)
    {
        $this->authorize('create', Post::class);

        $request->validate([
            'title' => ['required', 'string'],
        ]);

        $outline = $this->aiService->generateOutline($request->title);

        return response()->json([
            'success' => true,
            'outline' => $outline,
        ]);
    }
}
