<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class projet extends Model
{
    use HasFactory, SoftDeletes;
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tasks()
    {
        return $this->hasMany(Task::class, 'pro_id');
    }
    public function employees()
    {
        return $this->belongsToMany(User::class, 'tasks', 'pro_id', 'emp_id');
    }
    public function feedback() 
    {
        return $this->hasMany(Feedback::class, 'tag_id');
    }
}
