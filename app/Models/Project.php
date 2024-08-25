<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;
    protected $table = 'projects';
    protected $fillable = ['name', 'description', 'start_date', 'end_date', 'status'];


    public function project_assignments()
    {
        return $this->hasMany(ProjectAssignment::class);
    }

    public function kanbanboard()
    {
        return $this->hasMany(KanbanBoard::class);
    }

}