<?php

namespace App\Models;


use App\Traits\UsesTenantConnection;
use Illuminate\Container\Attributes\Tag;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $connection = 'mysql';

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'cpf',
        'rg',
        'date_of_birth',
        'hire_date',
        'position_id',
        'employment_status',
        'absence',
        'description',
        'city',
        'termination_date',
        'termination_type',
        'termination_reason',
        'notice_paid',
        'severance_amount',
        'last_vacation_date',
    ];

    protected $casts = [
        'hire_date' => 'date',
        'termination_date' => 'date',
        'last_vacation_date' => 'date',
        'notice_paid' => 'boolean',
        'severance_amount' => 'decimal:2',
    ];

    public function position()
    {
        return $this->belongsTo(Position::class);
    }

    public function salaries()
    {
        return $this->hasMany(Salary::class);
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    public function leaves()
    {
        return $this->hasMany(Leave::class);
    }

    public function documents()
    {
        return $this->hasMany(Document::class);
    }
    public function tags()
    {
        return $this->hasMany(Tags::class);
    }
    public function laborRights()
    {
        return $this->hasOne(LaborRight::class);
    }
    public function absences()
    {
        return $this->hasMany(Absence::class);
    }
    public function reports()
    {
        return $this->hasMany(Report::class);
    }
}