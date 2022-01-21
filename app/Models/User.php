<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory;
    use Notifiable;
    use HasRoles;

    /**
     * {@inheritDoc}
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * {@inheritDoc}
     */
    protected $casts = [
        'is_super_admin' => 'boolean',
    ];

    /**
     * {@inheritDoc}
     */
    protected static $logAttributes = [
        'name',
        'email',
        'updated_at',
    ];

    /**
     * {@inheritDoc}
     */
    protected $hidden = [
        'password',
        'remember_token',
        'api_token',
    ];

    /**
     * Determine if the user is an administrator.
     *
     * @return bool
     */
    public function isAdmin(): bool
    {
        return (bool) $this->is_super_admin;
    }
}
