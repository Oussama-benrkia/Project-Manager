<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens,SoftDeletes, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];
    public function scopeFilter($query , array $filter){
        //
    }
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
    
    public function projects()
    {
        return $this->hasMany(Projet::class);
    }

    public function managedTasks()
    {
        return $this->hasMany(Task::class, 'man_id');
    }

    public function assignedTasks()
    {
        return $this->hasMany(Task::class, 'emp_id');
    }

    public function feedbacks()
    {
        return $this->hasMany(Feedback::class);
    }
    public function many_projects()
    {
        return $this->belongsToMany(Project::class, 'tasks', 'emp_id', 'pro_id');
    }
    public function histories()
    {
        return $this->hasMany(History::class);
    }
}
