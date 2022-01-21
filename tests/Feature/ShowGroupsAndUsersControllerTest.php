<?php

namespace Tests\Feature;

use App\Traits\LocalGroupsTrait;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ShowGroupsAndUsersControllerTest extends TestCase
{
    use RefreshDatabase;
    use LocalGroupsTrait;

    public function testJsonForGroupsAndUsers()
    {
        $user = factory(\App\User::class)->states('admin')->create();
        $this->be($user);
        //arrange
        //factory out users
        $user_1 = factory(\App\User::class)->create();
        $user_2 = factory(\App\User::class)->create();
        //add them to groups
        $group_1 = "foo";
        $group_2 = "bar";

        $this->updateLocalGroups([$group_1]);
        $this->addUserToGroups($user_1);
        $this->addUserToGroups($user_2);
        $this->updateLocalGroups([$group_2]);
        $this->addUserToGroups($user_1);

        $this->json("GET", route("manageUsers.groups"))->assertStatus(200);
    }
}
