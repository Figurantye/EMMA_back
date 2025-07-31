<?php

namespace App\Models;

use App\Traits\UsesTenantConnection;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    protected $connection = 'mysql';

    protected $fillable = ['name', 'email', 'password', 'role', 'google_id'];

    protected $hidden = ['password', 'remember_token'];

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isHR()
    {
        return $this->role === 'user';
    }
}