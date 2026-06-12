<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Jobs\SendNewsletterBroadcast;
use App\Models\NewsletterCampaign;
use App\Models\User;
use Illuminate\Http\Request;

class NewsletterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny', NewsletterCampaign::class);

        $campaigns = NewsletterCampaign::latest()->paginate(20);
        $subscriberCount = User::where('newsletter', true)->count();

        return view('admin.newsletters.index', compact('campaigns', 'subscriberCount'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', NewsletterCampaign::class);

        return view('admin.newsletters.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create', NewsletterCampaign::class);

        $data = $request->validate([
            'subject' => ['required', 'string', 'max:255'],
            'body' => ['required', 'string'],
        ]);

        $campaign = NewsletterCampaign::create([
            'subject' => $data['subject'],
            'body' => $data['body'],
            'status' => 'draft',
        ]);

        return redirect()
            ->route('admin.newsletters.show', $campaign)
            ->with('success', 'Newsletter campaign draft created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(NewsletterCampaign $newsletter)
    {
        $this->authorize('update', $newsletter);

        return view('admin.newsletters.show', compact('newsletter'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(NewsletterCampaign $newsletter)
    {
        $this->authorize('update', $newsletter);

        if ($newsletter->status !== 'draft') {
            return redirect()
                ->route('admin.newsletters.show', $newsletter)
                ->with('error', 'Only draft campaigns can be edited.');
        }

        return view('admin.newsletters.edit', compact('newsletter'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, NewsletterCampaign $newsletter)
    {
        $this->authorize('update', $newsletter);

        if ($newsletter->status !== 'draft') {
            return redirect()
                ->route('admin.newsletters.show', $newsletter)
                ->with('error', 'Only draft campaigns can be updated.');
        }

        $data = $request->validate([
            'subject' => ['required', 'string', 'max:255'],
            'body' => ['required', 'string'],
        ]);

        $newsletter->update([
            'subject' => $data['subject'],
            'body' => $data['body'],
        ]);

        return redirect()
            ->route('admin.newsletters.show', $newsletter)
            ->with('success', 'Newsletter campaign draft updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(NewsletterCampaign $newsletter)
    {
        $this->authorize('delete', $newsletter);

        if ($newsletter->status !== 'draft') {
            return redirect()
                ->route('admin.newsletters.show', $newsletter)
                ->with('error', 'Sent campaigns cannot be deleted.');
        }

        $newsletter->delete();

        return redirect()
            ->route('admin.newsletters.index')
            ->with('success', 'Newsletter campaign draft deleted successfully.');
    }

    /**
     * Dispatch the newsletter sending job.
     */
    public function send(NewsletterCampaign $newsletter)
    {
        $this->authorize('update', $newsletter);

        if ($newsletter->status !== 'draft') {
            return redirect()
                ->route('admin.newsletters.show', $newsletter)
                ->with('error', 'This campaign has already been processed or sent.');
        }

        // Set status to sending immediately to prevent double sending
        $newsletter->update(['status' => 'sending']);

        SendNewsletterBroadcast::dispatch($newsletter->id);

        return redirect()
            ->route('admin.newsletters.show', $newsletter)
            ->with('success', 'Newsletter broadcast queued for sending.');
    }
}
