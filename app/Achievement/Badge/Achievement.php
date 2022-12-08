<?php

namespace App\Achievement\Badge;

use App\Models\User;

abstract class Achievement
{
    public $id;

    public function __construct()
    {
        $this->id = \App\Models\Achievement::firstOrCreate([
            'name' => $this->name,
            'desc' => $this->desc,
            'icon_path' => $this->icon
        ])->id;
    }

    public abstract function qualify(User $user);
}
