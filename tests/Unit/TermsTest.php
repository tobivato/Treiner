<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TermsTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testTerms()
    {
        $response = $this->get('/terms');
        $response->assertStatus(200);
    }
}
