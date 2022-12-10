<?php

namespace App\Achievement\CustomCollection;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class Achievements extends Collection
{
    public function for(User $user)
    {
        return $user->achievements;
    }

    public function remainingFor($user)
    {
        return $this->diff($user->achievements);
    }

    public function sortbyLevel($asc = null)
    {
        $asc ??= true;

        return $this->sortBy(function ($achievement){
           return $achievement->levelAsNumber();
        }, descending: !$asc)->values();
    }
}
