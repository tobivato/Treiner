<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class Mainpage extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testMain()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }
}
