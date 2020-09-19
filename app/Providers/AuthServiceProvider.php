<?php

namespace App\Providers;

use App\Models\Type;
use App\Policies\RecordPolicy;
use App\Policies\ServicePolicy;
use App\Policies\UserPolicy;
use App\TokenPassport;
use App\User;
use Carbon\Carbon;
use Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Laravel\Passport\Passport;
use Modules\Records\Models\Record;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Record::class => RecordPolicy::class,
        User::class   => UserPolicy::class,
    ];

    /**
     * The gates mappings for the application.
     *
     * @var array
     */
    protected $gates = [
//        'service' => 'App\Gates\ServiceGate',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        $this->registerGates();
        Passport::routes();
        //overriding default model Passport Token
        Passport::useTokenModel(TokenPassport::class);
        //set token expire_at (also fix error types data format datetime MSSQL 2013)
        Passport::personalAccessTokensExpireIn(Carbon::now()->addDays(60));
        Passport::refreshTokensExpireIn(Carbon::now()->addDays(60));
        Passport::tokensExpireIn(Carbon::now()->addDays(60));
        Passport::refreshTokensExpireIn(Carbon::now()->addDays(60));
        Gate::define('isAdmin', function($user) {
           return $user->admin == true;
        });
    }

    /**
     * Register the application's gates.
     *
     * @return void
     */
    public function registerGates()
    {
        foreach ($this->gates as $key => $value) {
            Gate::define($key, $value);
        }
    }
}
