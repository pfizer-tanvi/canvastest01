<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ManageUsersIndexTest extends TestCase
{
    use RefreshDatabase;

    public function testIndex()
    {
        $this->withoutMiddleware();
        \App\Models\User::factory()->count(2)->create();
        $response = $this->get(route("manageUsers.index"))->assertStatus(200)->json();
        $this->assertCount(2, $response['data']);
    }

    public function testSearch()
    {
        $this->withoutMiddleware();
        \App\Models\User::factory()->count(2)->create();
        \App\Models\User::factory()->create([
            'email' => "foobar@foo.com"
        ]);
        $response = $this->get(route("manageUsers.index", ['search' => "foobar@foo.com"]))->assertStatus(200)->json();
        $this->assertCount(1, $response['data']);
    }
}
