<?php

namespace Tests\Feature;

use App\ManageUsersRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ManageUsersRepositoryTest extends TestCase
{
    use RefreshDatabase;

    public function testGetUsers()
    {
        factory(\App\User::class, 2)->create();
        $response = new ManageUsersRepository();
        $this->assertNotNull($response->users());
    }

    public function testSearchUsers()
    {
        factory(\App\User::class, 2)->create();
        factory(\App\User::class, 1)->create([
            'email' => "foobar@foo.com"
        ]);
        $response = new ManageUsersRepository();
        $users = $response->users(['search' => "foobar@foo.com"]);
        $this->assertEquals(1, $users->total());
        $data = $users->items();
        $this->assertNotEmpty($data);
    }
}
