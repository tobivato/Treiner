<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PrivacyTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testPrivacy()
    {
        $response = $this->get('/privacy');
        $response->assertStatus(200);
    }
}
