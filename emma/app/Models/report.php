<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class report extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'content', 'employee_id'];

    public function employee(){
        return $this->belongsTo(Employee::class);
    }
}
