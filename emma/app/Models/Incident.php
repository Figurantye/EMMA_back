<?php

namespace App\Models;

use App\Traits\UsesTenantConnection;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Incident extends Model
{
    use HasFactory;

    protected $connection = 'mysql';

    protected $fillable = [
        'employee_id',
        'title',
        'description',
        'date',
        'severity',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
