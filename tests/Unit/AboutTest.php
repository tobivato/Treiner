<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AboutTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testAbout()
    {
       $response = $this->get('/about');
       $response->assertStatus(200);

    }
}