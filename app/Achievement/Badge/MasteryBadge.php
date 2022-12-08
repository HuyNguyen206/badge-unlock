<?php

namespace App\Achievement\Badge;

use App\Models\User;

class MasteryBadge extends  Achievement
{
    public $name = 'Ten thousand points';
    public $desc = 'Greate job! You are master now';
    public $icon = 'first-ten-thousand.svg';
    public $id;

    public function qualify(User $user)
    {
        return $user->point >= 10000;
    }
}
