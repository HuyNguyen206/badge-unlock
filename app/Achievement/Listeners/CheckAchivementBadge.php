<?php

namespace App\Achievement\Listeners;

use App\Achievement\Achievements;
use App\Achievement\Events\CalculateUserExperience;

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
     * @param  CalculateUserExperience  $event
     * @return void
     */
    public function handle(CalculateUserExperience $event)
    {
         $achievementsToAwardUser = resolve('achievements')
             ->filter->qualify($event->user)
             ->pluck('id');

         $event->user->achievements()->sync($achievementsToAwardUser);
    }
}
