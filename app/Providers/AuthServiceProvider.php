<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
// use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Laravel\Passport\Passport;


class AuthServiceProvider extends ServiceProvider {


public function boot()
{
    $this->registerPolicies();
    if (!$this->app->routesAreCached()) {
        // Passport::routes();
    }
    Passport::tokensExpireIn(now()->addDays(15));
    Passport::refreshTokensExpireIn(now()->addDays(15));
    Passport::personalAccessTokensExpireIn(now()->addMonths(5));
    

}
}