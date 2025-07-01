<?php

namespace App\Models;

use Illuminate\Container\Attributes\Tag;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name', 'last_name', 'email', 'phone', 'cpf', 'rg',
        'date_of_birth', 'hire_date', 'position_id', 'employment_status', 'absence', 'description', 'city'
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