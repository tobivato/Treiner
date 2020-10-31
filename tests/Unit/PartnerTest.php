<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PartnerTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testPartnerships()
    {
        $response = $this->get('/partnerships');
        $response->assertStatus(200);
    }
}
