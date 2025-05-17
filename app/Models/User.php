<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    protected $table = 'users';
    protected $primaryKey = 'user_ID';  

<<<<<<< HEAD
=======
    protected $table = 'users'; // explicitly set the table name

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
>>>>>>> origin/master
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'role',
        'profile_picture',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
<<<<<<< HEAD
}
=======
}
>>>>>>> origin/master
