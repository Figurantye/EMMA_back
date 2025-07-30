<?php

namespace App\Models;

use App\Traits\UsesTenantConnection;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class report extends Model
{
    use HasFactory;

    protected $connection = 'mysql';

    protected $fillable = ['title', 'content', 'employee_id'];

    public function employee(){
        return $this->belongsTo(Employee::class);
    }
}
