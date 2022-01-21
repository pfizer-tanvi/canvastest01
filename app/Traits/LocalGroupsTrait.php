<?php

namespace App\Traits;

use App\Models\User;
use Spatie\Permission\Exceptions\RoleAlreadyExists;
use Spatie\Permission\Models\Role;

trait LocalGroupsTrait
{
    /**
     * @var array
     */
    protected $groupsFromActiveDirectory = [];

    public function groupsFromActiveDirectory(): array
    {
        return $this->groupsFromActiveDirectory;
    }

    public function updateLocalGroups(array $groups): void
    {
        foreach ($groups as $group) {
            try {
                $this->groupsFromActiveDirectory[] = Role::create(['name' => $group]);
            } catch (RoleAlreadyExists $e) {
                $this->groupsFromActiveDirectory[] = Role::whereName($group)->first();
            }
        }
    }

    public function addUserToGroups(User $user): void
    {
        $user->assignRole($this->groupsFromActiveDirectory);
    }
}
