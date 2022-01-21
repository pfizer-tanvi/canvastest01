<?php

namespace Tests\Feature;

use App\Models\User;
use App\Traits\LocalGroupsTrait;
use Facades\App\Repositories\GroupsAndUsersListRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GroupsAndUsersListRepositoryTest extends FeatureTestCase
{
    use RefreshDatabase;
    use LocalGroupsTrait;

    public function testOutputGroupsAndUsers()
    {
        //arrange
        //factory out users
        $user_1 = User::factory()->create();
        $user_2 = User::factory()->create();
        //add them to groups
        $group_1 = "foo";
        $group_2 = "bar";

        $this->updateLocalGroups([$group_1]);
        $this->addUserToGroups($user_1);
        $this->addUserToGroups($user_2);
        $this->updateLocalGroups([$group_2]);
        $this->addUserToGroups($user_1);

        //act
        //get repo and output that info
        $results = GroupsAndUsersListRepository::handle();

        //assert
        //output has groups and users emails in group
        $results = $results->toArray();
        $this->assertNotNull($results);
        $this->assertCount(2, $results[0]['users']);
        $this->assertCount(1, $results[1]['users']);
    }
}
