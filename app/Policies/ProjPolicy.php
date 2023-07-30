<?php

namespace App\Policies;

use App\Models\User;
use App\Models\projet;
use Illuminate\Auth\Access\Response;

class ProjPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny()
    {
        return auth()->user()->role==='admin';
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, projet $projet)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     */
    public function create()
    {
        return auth()->user()->role==='admin';
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, projet $projet)
    {
        return  ($user->role=='manager'&& $projet->user_id==$user->id)||$user->role=='admin';
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, projet $projet)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, projet $projet)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, projet $projet)
    {
        //
    }
}
