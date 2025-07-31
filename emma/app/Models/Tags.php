<?php

namespace App\Models;

use App\Traits\UsesTenantConnection;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tags extends Model
{
    use HasFactory;

    protected $connection = 'mysql';

    protected $fillable = ['employee_id', 'color', 'content'];

    public function employee() 
    {
        return $this->belongsTo(Employee::class);
    }
}
