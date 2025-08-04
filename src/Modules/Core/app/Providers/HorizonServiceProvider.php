<?php

namespace Modules\Core\app\Providers;

use Illuminate\Support\Facades\Gate;
use JetBrains\PhpStorm\NoReturn;
use Laravel\Horizon\HorizonApplicationServiceProvider;
//use Modules\User\Models\User;

class HorizonServiceProvider extends HorizonApplicationServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        parent::boot();

        // Horizon::routeSmsNotificationsTo('15556667777');
        // Horizon::routeMailNotificationsTo('example@example.com');
        // Horizon::routeSlackNotificationsTo('slack-webhook-url', '#channel');
    }

    /**
     * Register the Horizon gate.
     *
     * This gate determines who can access Horizon in non-local environments.
     */
    #[NoReturn] protected function gate(): void
    {
        Gate::define('viewHorizon', function () {
            /*$user = User::find(auth()->guard('web')->user()->id)->with('permissions')->first();
            if(!$user){
                return false;
            }
            return in_array( 'admin.horizon',$user->roles()->first()->permissions->pluck('name')->toArray());*/
            return true;
        });
    }
}
