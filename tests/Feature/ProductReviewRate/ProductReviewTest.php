<?php

namespace Tests\Feature\ProductReviewRate;

use Tests\TestCase;

class ProductReviewTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
