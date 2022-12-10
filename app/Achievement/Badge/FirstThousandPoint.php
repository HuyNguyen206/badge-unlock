<?php

namespace App\Achievement\Badge;

use App\Models\User;

class FirstThousandPoint extends Achievement
{
    public $desc = 'Greate job! You are on right way update';
    public $icon = 'first-thousand.svg';
    public $level = 'beginner';

    public function qualify(User $user)
    {
        return $user->point >= 1000;
    }
}
