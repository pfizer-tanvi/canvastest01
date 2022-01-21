<?php

namespace App;

use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Support\Arr;

class ManageUsersRepository
{
    public function users(array $payload = []): Paginator
    {
        return User::where(
            "email",
            "LIKE",
            "%" . Arr::get($payload, 'search') . "%"
        )->paginate();
    }
}
