<?php

namespace Tests\Feature;

use App\Models\User;
use App\Traits\LocalGroupsTrait;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;

class LocalGroupsTraitTest extends FeatureTestCase
{
    use RefreshDatabase;
    use LocalGroupsTrait;

    public function testMakeLocalGroupsFromArray(): void
    {
        $array = ['foo', 'bar'];

        $this->updateLocalGroups($array);

        $this->assertDatabaseHas('roles', [
            'name' => 'foo',
        ]);

        $this->assertDatabaseHas('roles', [
            'name' => 'bar',
        ]);

        $groupsInTrait = $this->groupsFromActiveDirectory();

        $this->assertCount(2, $groupsInTrait);
    }

    public function testDoesNotFailOnExistingRoles(): void
    {
        $array = ['foo', 'bar'];

        Role::create(['name' => 'foo']);

        $this->updateLocalGroups($array);

        $this->assertDatabaseHas('roles', [
            'name' => 'foo',
        ]);

        $this->assertDatabaseHas('roles', [
            'name' => 'bar',
        ]);

        $groupsInTrait = $this->groupsFromActiveDirectory();

        $this->assertCount(2, $groupsInTrait);
    }

    public function testUserAddedToRoles(): void
    {
        $user = User::factory()->create();
        $array = ['foo', 'bar'];
        Role::create(['name' => 'foo']);
        Role::create(['name' => 'bar']);
        $this->updateLocalGroups($array);
        $this->addUserToGroups($user);
        $this->assertCount(2, $user->refresh()->roles->toArray());
    }
}
