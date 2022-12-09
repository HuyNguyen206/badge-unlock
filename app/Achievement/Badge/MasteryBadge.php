<?php

namespace App\Achievement\Badge;

use App\Models\User;

class MasteryBadge extends  Achievement
{
    public $name = 'MasteryAchievementBadge';
    public $desc = 'Greate job! You are master now';
    public $icon = 'first-ten-thousand.svg';

    public function qualify(User $user)
    {
        return $user->point >= 10000;
    }
}
