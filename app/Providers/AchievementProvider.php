<?php

namespace App\Providers;

use App\Achievement\Achievements;
use App\Models\User;
use Illuminate\Support\ServiceProvider;

class AchievementProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->singleton(Achievements::class, function (){
            $achievement = new Achievements();
            $achievement->register('Moving on Up', function (User $user){
                return $user->point >= 1000;
            }, 'some-badge.svg');

            $achievement->register('Mastery badge', function (User $user){
                return $user->point >= 10000;
            }, 'some-mastery-badge.svg');

            return $achievement;
        });
    }
}
