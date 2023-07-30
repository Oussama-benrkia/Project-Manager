<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class feedback extends Model
{
    use HasFactory,SoftDeletes;

    public function task()
    {
        return $this->belongsTo(Task::class, 'tag_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function project()
    {
        return $this->belongsTo(Project::class, 'tag_id');
    }
}
