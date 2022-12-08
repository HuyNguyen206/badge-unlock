<?php

namespace App\Achievement\Listeners;

use App\Achievement\Achievements;
use App\Achievement\Events\UserEarnExperience;

class CheckAchivementBadge
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  UserEarnExperience  $event
     * @return void
     */
    public function handle(UserEarnExperience $event)
    {
         $achievementsToAwardUser = resolve('achievements')
             ->filter->qualify($event->user)
             ->pluck('id');

         $event->user->achievements()->sync($achievementsToAwardUser);
    }
}
