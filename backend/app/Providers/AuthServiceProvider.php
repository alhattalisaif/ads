<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\Ad;
use App\Policies\AdPolicy;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Ad::class => AdPolicy::class,
    ];

    public function boot(): void
    {
        $this->registerPolicies();

        // Additional gates can be defined here
    }
}
