<?php

namespace App\Achievement\Badge;

use App\Models\User;

class ThreeThousandPoint extends Achievement
{
    public $desc = 'Three thousand point';
    public $icon = 'three.svg';

    public function qualify(User $user)
    {
        return $user->point >= 3000;
    }
}
