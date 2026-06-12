<?php

namespace Tests\Feature\Public;

use App\Models\Category;
use App\Models\Page;
use App\Models\Post;
use App\Models\User;
use App\Services\SettingsService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicPageTest extends TestCase
{
    use RefreshDatabase;

    private User $author;

    private Page $publishedPage;

    private Page $draftPage;

    protected function setUp(): void
    {
        parent::setUp();

        $this->author = User::factory()->create(['slug' => 'editorial-author']);

        $this->publishedPage = Page::create([
            'user_id' => $this->author->id,
            'title' => 'About Us Static',
            'slug' => 'about-us-static',
            'body' => '<p>Welcome to our editorial room content.</p>',
            'status' => 'published',
        ]);

        $this->draftPage = Page::create([
            'user_id' => $this->author->id,
            'title' => 'Draft Static',
            'slug' => 'draft-static',
            'body' => '<p>Under construction content.</p>',
            'status' => 'draft',
        ]);
    }

    public function test_can_view_published_static_page(): void
    {
        $response = $this->get(route('pages.show', $this->publishedPage->slug));

        $response->assertStatus(200);
        $response->assertSee('About Us Static');
        $response->assertSee('Welcome to our editorial room content.', false);
    }

    public function test_cannot_view_draft_static_page(): void
    {
        $response = $this->get(route('pages.show', $this->draftPage->slug));
        $response->assertStatus(404);
    }

    public function test_view_non_existent_page_returns_404(): void
    {
        $response = $this->get('/pages/non-existent-slug-1234');
        $response->assertStatus(404);
    }

    public function test_homepage_falls_back_to_default_listing_without_layout_config(): void
    {
        SettingsService::set('homepage_layout', null);

        // Create some posts to make sure default layout renders them
        $post = Post::create([
            'user_id' => $this->author->id,
            'title' => 'Fallback Post Title',
            'slug' => 'fallback-post-title',
            'body' => 'Body content.',
            'status' => 'published',
            'published_at' => now(),
        ]);

        $response = $this->get(route('home'));
        $response->assertStatus(200);
        $response->assertViewHas('featuredPost');
        $response->assertViewHas('posts');
        $response->assertSee('Fallback Post Title');
    }

    public function test_homepage_renders_custom_widgets_when_layout_is_configured(): void
    {
        $category = Category::create([
            'name' => 'Editorial Beats',
            'slug' => 'editorial-beats',
            'is_visible' => true,
        ]);

        $post = Post::create([
            'user_id' => $this->author->id,
            'category_id' => $category->id,
            'title' => 'Widget Specific Article',
            'slug' => 'widget-specific-article',
            'body' => 'Body.',
            'status' => 'published',
            'published_at' => now(),
        ]);

        $layoutPayload = [
            [
                'id' => 1,
                'type' => 'hero',
                'name' => 'Hero Banner',
                'settings' => [
                    'headline' => 'Visual Canvas Studio',
                    'subtext' => 'The ultimate design system experience.',
                    'cta_label' => 'Explore Studio',
                    'cta_link' => '/studio',
                    'theme' => 'gold-black',
                ],
            ],
            [
                'id' => 2,
                'type' => 'strip',
                'name' => 'Latest News Strip',
                'settings' => [
                    'items' => 3,
                ],
            ],
            [
                'id' => 3,
                'type' => 'grid',
                'name' => 'Featured Posts Grid',
                'settings' => [
                    'limit' => 3,
                    'category' => 'all',
                    'style' => 'grid',
                ],
            ],
            [
                'id' => 4,
                'type' => 'categories',
                'name' => 'Category Showcase',
                'settings' => [
                    'heading' => 'Browse Our Sounds',
                ],
            ],
            [
                'id' => 5,
                'type' => 'newsletter',
                'name' => 'Newsletter Signup',
                'settings' => [
                    'placeholder' => 'Enter mailing address...',
                    'cta' => 'Subscribe',
                ],
            ],
        ];

        SettingsService::set('homepage_layout', json_encode($layoutPayload));

        $response = $this->get(route('home'));
        $response->assertStatus(200);

        // 1. Assert Hero Widget
        $response->assertSee('Visual Canvas Studio');
        $response->assertSee('Explore Studio');

        // 2. Assert News Strip Widget
        $response->assertSee('Latest News');
        $response->assertSee('Widget Specific Article');

        // 3. Assert Grid Widget
        $response->assertSee('Featured Editorial');

        // 4. Assert Categories Widget
        $response->assertSee('Browse Our Sounds');
        $response->assertSee('Editorial Beats');

        // 5. Assert Newsletter Widget
        $response->assertSee('Join the Debesties Circle');
        $response->assertSee('Enter mailing address...');
    }
}
