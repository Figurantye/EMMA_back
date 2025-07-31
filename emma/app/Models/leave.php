<?php

namespace App\Models;


use App\Traits\UsesTenantConnection;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Leave extends Model
{
    use HasFactory;

    protected $connection = 'mysql';

    protected $fillable = ['employee_id', 'type', 'reason', 'start_date', 'end_date', 'status'];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}