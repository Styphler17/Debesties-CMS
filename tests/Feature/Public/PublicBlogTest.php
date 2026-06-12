<?php

namespace Tests\Feature\Public;

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

class PublicBlogTest extends TestCase
{
    use RefreshDatabase;

    private User $user;
    private Category $category;
    private Post $publishedPost;
    private Post $draftPost;
    private Tag $tag;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create(['slug' => 'test-user']);
        
        $this->category = Category::create([
            'name' => 'Tech',
            'slug' => 'tech',
            'is_visible' => true,
        ]);

        $this->tag = Tag::create([
            'name' => 'Laravel',
            'slug' => 'laravel',
        ]);

        $this->publishedPost = Post::create([
            'user_id' => $this->user->id,
            'category_id' => $this->category->id,
            'title' => 'My Published Article',
            'slug' => 'my-published-article',
            'body' => 'Here is some published content.',
            'status' => 'published',
            'published_at' => now(),
        ]);
        $this->publishedPost->tags()->sync([$this->tag->id]);

        $this->draftPost = Post::create([
            'user_id' => $this->user->id,
            'category_id' => $this->category->id,
            'title' => 'My Draft Article',
            'slug' => 'my-draft-article',
            'body' => 'Here is draft content.',
            'status' => 'draft',
        ]);
    }

    public function test_home_page_loads_and_displays_posts(): void
    {
        $response = $this->get(route('home'));

        $response->assertStatus(200);
        $response->assertViewHas('featuredPost');
        $response->assertViewHas('posts');
    }

    public function test_article_detail_page_loads_and_increments_view_count(): void
    {
        $this->assertEquals(0, $this->publishedPost->view_count);

        $response = $this->get(route('posts.show', $this->publishedPost->slug));

        $response->assertStatus(200);
        $response->assertViewHas('post');
        $response->assertViewHas('comments');
        $response->assertViewHas('seo');

        $this->assertEquals(1, $this->publishedPost->fresh()->view_count);
    }

    public function test_article_detail_page_aborts_for_draft(): void
    {
        $response = $this->get(route('posts.show', $this->draftPost->slug));
        $response->assertStatus(404);
    }

    public function test_category_page_loads_and_displays_posts(): void
    {
        $response = $this->get(route('categories.show', $this->category->slug));

        $response->assertStatus(200);
        $response->assertViewHas('category');
        $response->assertViewHas('posts');
    }

    public function test_category_page_aborts_for_invisible_category(): void
    {
        $invisibleCategory = Category::create([
            'name' => 'Hidden',
            'slug' => 'hidden',
            'is_visible' => false,
        ]);

        $response = $this->get(route('categories.show', $invisibleCategory->slug));
        $response->assertStatus(404);
    }

    public function test_tag_page_loads_and_displays_posts(): void
    {
        $response = $this->get(route('tags.show', $this->tag->slug));

        $response->assertStatus(200);
        $response->assertViewHas('tag');
        $response->assertViewHas('posts');
    }

    public function test_author_page_loads_and_displays_posts(): void
    {
        $response = $this->get(route('authors.show', $this->user->slug));

        $response->assertStatus(200);
        $response->assertViewHas('user');
        $response->assertViewHas('posts');
    }

    public function test_search_validates_query_length(): void
    {
        // 1. Less than 2 characters - redirects back with session error
        $response = $this->from(route('home'))->get(route('search', ['q' => 'a']));
        $response->assertRedirect(route('home'));
        $response->assertSessionHas('error');

        // 2. Minimum 2 characters - displays search results
        $response2 = $this->get(route('search', ['q' => 'published']));
        $response2->assertStatus(200);
        $response2->assertViewHas('posts');
        $response2->assertViewHas('query', 'published');
    }

    public function test_sitemap_loads_correct_xml_structure_and_caching(): void
    {
        Cache::forget('sitemap_xml');

        $response = $this->get(route('sitemap'));

        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'application/xml');
        $this->assertStringContainsString('</urlset>', $response->getContent());
        $this->assertStringContainsString($this->publishedPost->slug, $response->getContent());
        $this->assertStringNotContainsString($this->draftPost->slug, $response->getContent());

        // Assert cached
        $this->assertTrue(Cache::has('sitemap_xml'));
    }
}
