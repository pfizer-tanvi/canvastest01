<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Spatie\Permission\Models\Role;

class GroupsAndUsersListRepository
{


    public function handle(): Collection
    {
        return Role::with('users')->get();
    }
}
