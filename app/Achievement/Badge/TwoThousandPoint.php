<?php

namespace App\Achievement\Badge;

use App\Models\User;

class TwoThousandPoint extends Achievement
{
    public $desc = 'Two thousand point';
    public $icon = 'two.svg';
    public $level = 'beginner';

    public function qualify(User $user)
    {
        return $user->point >= 2000;
    }
}
