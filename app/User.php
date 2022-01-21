<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;
use Ramsey\Uuid\Uuid;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use Notifiable;
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be logged.
     *
     * @var array
     */
    protected static $logAttributes = ['name', 'email', 'updated_at'];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', "api_token"
    ];


    public function createUser(array $userPayload): User
    {
        $user = $this->create([
            'name' => Arr::get($userPayload, 'email'),
            'email' => Arr::get($userPayload, 'email'),
            'password' => Hash::make(Uuid::uuid4()->toString())
        ]);
        $user->is_super_admin = Arr::get($userPayload, 'is_super_admin', 0);
        $user->save();
        return $user->refresh();
    }

    public function updateUser(User $user, array $userPayload): User
    {
        $user->email = Arr::get($userPayload, 'email');
        $user->name = Arr::get($userPayload, 'email');
        $user->password = Hash::make(Uuid::uuid4()->toString());
        $user->is_super_admin = Arr::get($userPayload, 'is_super_admin', 0);
        $user->save();
        return $user->refresh();
    }
}
