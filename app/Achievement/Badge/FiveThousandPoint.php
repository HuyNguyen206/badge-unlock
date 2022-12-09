<?php

namespace App\Achievement\Badge;

use App\Models\User;

class FiveThousandPoint extends Achievement
{
    public $desc = 'Five thousand point';

    public function qualify(User $user)
    {
        return $user->point >= 5000;
    }
}
