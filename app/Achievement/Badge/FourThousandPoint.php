<?php

namespace App\Achievement\Badge;

use App\Models\User;

class FourThousandPoint extends Achievement
{
    public $desc = 'Four thousand point';
    public $icon = 'four.svg';

    public function qualify(User $user)
    {
        return $user->point >= 4000;
    }
}
