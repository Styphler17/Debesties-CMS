<?php

namespace App\Jobs;

use App\Mail\NewsletterMail;
use App\Models\NewsletterCampaign;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendNewsletterBroadcast implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(public readonly int $campaignId) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $campaign = NewsletterCampaign::find($this->campaignId);

        if (! $campaign || $campaign->status === 'sent') {
            return;
        }

        $campaign->status = 'sending';
        $campaign->save();

        $subscribers = User::where('newsletter', true)->get();
        $sentCount = 0;

        foreach ($subscribers as $subscriber) {
            Mail::to($subscriber->email)->send(new NewsletterMail($campaign->subject, $campaign->body));
            $sentCount++;
        }

        $campaign->sent_to_count = $sentCount;
        $campaign->status = 'sent';
        $campaign->sent_at = now();
        $campaign->save();
    }
}
