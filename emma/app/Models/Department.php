<?php

namespace App\Models;

use App\Traits\UsesTenantConnection;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    protected $connection = 'mysql';
    
    protected $fillable = ['department', 'description'];

    public function positions()
    {
        return $this->hasMany(Position::class);
    }
}