<?php

namespace Tests\Feature\Api;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ContentApiTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_get_content(): void
    {
        $response = $this->get('/api/content/test-1');

        $response->assertStatus(200);
    }
}
