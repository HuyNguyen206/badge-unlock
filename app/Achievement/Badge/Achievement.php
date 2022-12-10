<?php

namespace App\Achievement\Badge;

use App\Models\User;
use Illuminate\Support\Str;

abstract class Achievement
{
    public $name;
    public $icon;
    public $id;
    public $level = 'intermediate';

    public function __construct()
    {
        $this->name = $this->name ?? Str::headline(class_basename($this));
        $this->icon = $this->icon ?? Str::kebab(class_basename($this)).'.svg';
    }

    public abstract function qualify(User $user);
}
