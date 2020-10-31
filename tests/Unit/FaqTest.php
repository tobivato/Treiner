<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FaqTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testFaq()
    {
        $response = $this->get('/faq');
        $response->assertStatus(200);
    }
}
