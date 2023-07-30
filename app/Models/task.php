<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class task extends Model
{
    use HasFactory,SoftDeletes;


    public function manager()
    {
        return $this->belongsTo(User::class, 'man_id');
    }

    public function employee()
    {
        return $this->belongsTo(User::class, 'emp_id');
    }

    public function project()
    {
        return $this->belongsTo(Projet::class, 'pro_id');
    }

    public function feedbacks()
    {
        return $this->hasMany(Feedback::class, 'tag_id');
    }
}
