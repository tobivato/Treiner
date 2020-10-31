<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SuppportTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testSupport()
    {
        $response = $this->get('/support');
        $response->assertStatus(200);
    }
}
