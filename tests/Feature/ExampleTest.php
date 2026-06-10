<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_admin_dashboard_returns_a_successful_response(): void
    {
        $response = $this->get('/admin');

        $response->assertStatus(200);
        $response->assertSee('Dashboard');
    }

    public function test_article_route_returns_a_successful_response(): void
    {
        $response = $this->get('/my-awesome-post');

        $response->assertStatus(200);
        $response->assertSee('my-awesome-post');
    }
}
