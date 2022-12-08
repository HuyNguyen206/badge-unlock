<?php

namespace App\Achievement\Badge;

use App\Models\User;

class FirstThousandPoint extends Achievement
{
    public $name = 'First thousand points';
    public $desc = 'Greate job! You are on right way';
    public $icon = 'first-thousand.svg';
    public $id;

    public function qualify(User $user)
    {
        return $user->point >= 1000;
    }
}
