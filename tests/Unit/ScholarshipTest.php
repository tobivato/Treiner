<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ScholarshipTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testScholarships()
    {
        $response = $this->get('/scholarships');
        $response->assertStatus(200);
    }
}
