<?php

namespace Tests\Feature;

use App\ManageUsersRepository;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ManageUsersRepositoryTest extends TestCase
{
    use RefreshDatabase;

    public function testGetUsers()
    {
        User::factory()->count(2)->create();
        $response = new ManageUsersRepository();
        $this->assertNotNull($response->users());
    }

    public function testSearchUsers()
    {
        User::factory()->count(2)->create();
        User::factory()->count(1)->create([
            'email' => "foobar@foo.com",
        ]);
        $response = new ManageUsersRepository();
        $users = $response->users(['search' => "foobar@foo.com"]);
        $this->assertEquals(1, $users->total());
        $data = $users->items();
        $this->assertNotEmpty($data);
    }
}
