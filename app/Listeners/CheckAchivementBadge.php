<?php

namespace App\Listeners;

use App\Events\UserEarnExperience;

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
     * @param  \App\Events\UserEarnExperience  $event
     * @return void
     */
    public function handle(UserEarnExperience $event)
    {
        //
    }
}
