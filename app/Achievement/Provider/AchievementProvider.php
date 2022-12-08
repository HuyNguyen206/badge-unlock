<?php

namespace App\Achievement\Provider;

use App\Achievement\Achievements;
use App\Achievement\Badge\FirstThousandPoint;
use App\Achievement\Badge\MasteryBadge;
use App\Achievement\Events\UserEarnExperience;
use App\Achievement\Listeners\CheckAchivementBadge;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

class AchievementProvider extends ServiceProvider
{
    protected $achievements = [
        FirstThousandPoint::class,
        MasteryBadge::class
    ];

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('achievements', function () {
            $achievements = collect();
            foreach ($this->achievements as $achievement) {
                $achievements->push(resolve($achievement));
            }

            return $achievements;
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Event::listen(UserEarnExperience::class, CheckAchivementBadge::class);
    }
}
