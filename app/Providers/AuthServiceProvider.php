<?php

namespace App\Providers;

use Ilunimate\Foundation\Support\Provider\AuthServiceProvider as ServiceProvider;
// use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Laravel\Passport\Passport;


class AuthServiceProvider extends ServiceProvider
{


public function boot()
{
    $this->registerPolicies();
    if (!this->app->routesArecashed()){
        Passport::routes();
    }
    Passport::tokensExpireIn(now()->addDays(15));
    Passport::refreshTokensExpireIn(now()->addDays(15));
    Passport::personalAccessTokensExpireIn(now()->addMonths(5));
    

}
}