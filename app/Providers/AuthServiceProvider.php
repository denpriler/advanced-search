<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Models\HomeAdvisor\HomeAdvisorItem;
use App\Policies\HomeAdvisor\HomeAdvisorItemPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        HomeAdvisorItem::class => HomeAdvisorItemPolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //
    }
}