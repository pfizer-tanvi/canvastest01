<?php

namespace Tests\Feature;

use App\Traits\LocalGroupsTrait;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class LocalGroupsTraitTest extends TestCase
{

    use RefreshDatabase;
    use LocalGroupsTrait;


    public function testMakeLocalGroupsFromArray()
    {
        $array = ['foo', 'bar'];

        $this->updateLocalGroups($array);

        $this->assertDatabaseHas('roles', [
            'name' => "foo"
        ]);
        $this->assertDatabaseHas('roles', [
            'name' => "bar"
        ]);

        $groupsInTrait = $this->groupsFromActiveDirectory();

        $this->assertCount(2, $groupsInTrait);
    }



    public function testDoesNotFailOnExistingRoles()
    {
        $array = ['foo', 'bar'];
        Role::create(['name' => "foo"]);

        $this->updateLocalGroups($array);

        $this->assertDatabaseHas('roles', [
            'name' => "foo"
        ]);
        $this->assertDatabaseHas('roles', [
            'name' => "bar"
        ]);
        $groupsInTrait = $this->groupsFromActiveDirectory();
        $this->assertCount(2, $groupsInTrait);
    }

    public function testUserAddedToRoles()
    {
        $user = \App\Models\User::factory()->create();
        $array = ['foo', 'bar'];
        Role::create(['name' => "foo"]);
        Role::create(['name' => "bar"]);
        $this->updateLocalGroups($array);
        $this->addUserToGroups($user);
        $this->assertCount(2, $user->refresh()->roles->toArray());
    }
}
