<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ChecklistTemplateItem extends Model
{
    use HasFactory;

    protected $fillable = ['checklist_template_id', 'title', 'description'];

    public function template()
    {
        return $this->belongsTo(ChecklistTemplate::class);
    }
}