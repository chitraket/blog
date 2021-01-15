<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::resource('posts','App\Policies\PostPolicy');
        Gate::resource('tags','App\Policies\TagPolicy');
        Gate::resource('categorys','App\Policies\CategoryPolicy');
        Gate::resource('users','App\Policies\UserPolicy');
        Gate::resource('roles','App\Policies\RolePolicy');
        Gate::resource('permissions','App\Policies\PermissionPolicy');
        Gate::resource('subadmin','App\Policies\SubAdminPolicy');
        Gate::resource('comment','App\Policies\CommentPolicy');
        Gate::resource('favorite','App\Policies\FavoritePolicy');
        //
    }
}
