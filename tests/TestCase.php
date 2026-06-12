<?php

namespace Tests;

use Illuminate\Foundation\Http\Middleware\ValidateCsrfToken;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        // Globally bypass CSRF in tests to avoid 419 errors
        $this->withoutMiddleware([ValidateCsrfToken::class]);
    }
}
