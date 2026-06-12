<?php

namespace Tests\Feature\Admin;

use App\Jobs\SendNewsletterBroadcast;
use App\Mail\NewsletterMail;
use App\Models\NewsletterCampaign;
use App\Models\Role;
use App\Models\User;
use Database\Seeders\RolesAndPermissionsSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class NewsletterControllerTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;
    private User $subscriber;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(RolesAndPermissionsSeeder::class);

        $this->admin = User::factory()->create();
        $this->admin->roles()->sync([Role::where('slug', 'super_admin')->first()->id]);

        $this->subscriber = User::factory()->create();
        $this->subscriber->roles()->sync([Role::where('slug', 'subscriber')->first()->id]);
    }

    public function test_guest_blocked_from_newsletters()
    {
        $this->get(route('admin.newsletters.index'))
            ->assertRedirect(route('admin.login'));
    }

    public function test_subscriber_blocked_from_newsletters()
    {
        $this->actingAs($this->subscriber)
            ->get(route('admin.newsletters.index'))
            ->assertStatus(403);
    }

    public function test_admin_can_access_newsletters_index()
    {
        $response = $this->actingAs($this->admin)->get(route('admin.newsletters.index'));
        $response->assertStatus(200);
        $response->assertViewHas('campaigns');
        $response->assertViewHas('subscriberCount');
    }

    public function test_admin_can_create_newsletter_campaign_draft()
    {
        $response = $this->actingAs($this->admin)->post(route('admin.newsletters.store'), [
            'subject' => 'Weekly Pulse',
            'body' => 'Welcome to the pulse of technology.',
        ]);

        $campaign = NewsletterCampaign::firstOrFail();
        $response->assertRedirect(route('admin.newsletters.show', $campaign));
        
        $this->assertDatabaseHas('newsletter_campaigns', [
            'subject' => 'Weekly Pulse',
            'body' => 'Welcome to the pulse of technology.',
            'status' => 'draft',
        ]);
    }

    public function test_admin_can_update_newsletter_campaign_draft()
    {
        $campaign = NewsletterCampaign::create([
            'subject' => 'Old Subject',
            'body' => 'Old Body',
            'status' => 'draft',
        ]);

        $response = $this->actingAs($this->admin)->put(route('admin.newsletters.update', $campaign), [
            'subject' => 'New Subject',
            'body' => 'New Body',
        ]);

        $response->assertRedirect(route('admin.newsletters.show', $campaign));
        $this->assertDatabaseHas('newsletter_campaigns', [
            'id' => $campaign->id,
            'subject' => 'New Subject',
            'body' => 'New Body',
        ]);
    }

    public function test_admin_cannot_update_sent_newsletter()
    {
        $campaign = NewsletterCampaign::create([
            'subject' => 'Sent Subject',
            'body' => 'Sent Body',
            'status' => 'sent',
        ]);

        $response = $this->actingAs($this->admin)->put(route('admin.newsletters.update', $campaign), [
            'subject' => 'New Subject',
            'body' => 'New Body',
        ]);

        $response->assertRedirect(route('admin.newsletters.show', $campaign));
        $response->assertSessionHas('error');
    }

    public function test_admin_can_delete_newsletter_campaign_draft()
    {
        $campaign = NewsletterCampaign::create([
            'subject' => 'Draft Subject',
            'body' => 'Draft Body',
            'status' => 'draft',
        ]);

        $response = $this->actingAs($this->admin)->delete(route('admin.newsletters.destroy', $campaign));

        $response->assertRedirect(route('admin.newsletters.index'));
        $this->assertDatabaseMissing('newsletter_campaigns', ['id' => $campaign->id]);
    }

    public function test_admin_can_send_broadcast_job_dispatched()
    {
        Queue::fake();

        $campaign = NewsletterCampaign::create([
            'subject' => 'Broadcast Subject',
            'body' => 'Broadcast Body',
            'status' => 'draft',
        ]);

        $response = $this->actingAs($this->admin)->post(route('admin.newsletters.send', $campaign));

        $response->assertRedirect(route('admin.newsletters.show', $campaign));
        
        $campaign->refresh();
        $this->assertEquals('sending', $campaign->status);

        Queue::assertPushed(SendNewsletterBroadcast::class, function ($job) use ($campaign) {
            return $job->campaignId === $campaign->id;
        });
    }

    public function test_broadcast_job_sends_emails_to_subscribers()
    {
        Mail::fake();

        // Create subscribers
        $sub1 = User::factory()->create(['newsletter' => true]);
        $sub2 = User::factory()->create(['newsletter' => true]);
        $nonSub = User::factory()->create(['newsletter' => false]);

        $campaign = NewsletterCampaign::create([
            'subject' => 'Subscribers Only',
            'body' => 'Body content for sub',
            'status' => 'draft',
        ]);

        // Run the job synchronously
        (new SendNewsletterBroadcast($campaign->id))->handle();

        $campaign->refresh();
        $this->assertEquals('sent', $campaign->status);
        $expectedCount = User::where('newsletter', true)->count();
        $this->assertEquals($expectedCount, $campaign->sent_to_count);
        $this->assertNotNull($campaign->sent_at);

        Mail::assertSent(NewsletterMail::class, function ($mail) use ($sub1) {
            return $mail->hasTo($sub1->email) && $mail->subjectStr === 'Subscribers Only';
        });

        Mail::assertSent(NewsletterMail::class, function ($mail) use ($sub2) {
            return $mail->hasTo($sub2->email);
        });

        Mail::assertNotSent(NewsletterMail::class, function ($mail) use ($nonSub) {
            return $mail->hasTo($nonSub->email);
        });
    }
}
