<?php

namespace Tests\Feature\Actions;

use App\Actions\SEO\GenerateSlug;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GenerateSlugTest extends TestCase
{
    use RefreshDatabase;

    private GenerateSlug $action;

    protected function setUp(): void
    {
        parent::setUp();
        $this->action = new GenerateSlug;
    }

    public function test_generates_basic_slug(): void
    {
        $slug = $this->action->handle('Awards History', 'categories');

        $this->assertSame('awards-history', $slug);
    }

    public function test_appends_2_on_collision(): void
    {
        Category::create([
            'name' => 'Awards History',
            'slug' => 'awards-history',
        ]);

        $slug = $this->action->handle('Awards History', 'categories');

        $this->assertSame('awards-history-2', $slug);
    }

    public function test_appends_3_on_double_collision(): void
    {
        Category::create(['name' => 'Awards History', 'slug' => 'awards-history']);
        Category::create(['name' => 'Awards History 2', 'slug' => 'awards-history-2']);

        $slug = $this->action->handle('Awards History', 'categories');

        $this->assertSame('awards-history-3', $slug);
    }
}
