<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use App\Models\projet;
use App\Policies\ProjPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
       // projet::class=>ProjPolicy::class,
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();
        Gate::define('acces_user',function($user){
            return auth()->user()->role=='admin' || auth()->user()->role=='manager';
        });
        Gate::define('acces_mana',function(){
            return auth()->user()->role=='admin' ;
        });
      /*  Gate::define('acces_pro',function(){
            return auth()->user()->role=='admin' ;//||(auth()->user()->role=='manager' & $data->user_id==auth()->user()->id) ;
        });*/
    }
}
