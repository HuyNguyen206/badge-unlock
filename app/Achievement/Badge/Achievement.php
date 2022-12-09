<?php

namespace App\Achievement\Badge;

use App\Models\User;
use Illuminate\Support\Str;

abstract class Achievement
{
    public $name;
    public $icon;
    public $id;

    public function __construct()
    {
        $this->name = $this->name ?? Str::headline(class_basename($this));
        $this->icon = $this->icon ?? Str::kebab(class_basename($this)).'.svg';
//        $this->id = \App\Models\Achievement::query()->updateOrCreate(
//            [
//                'class_name' => class_basename($this)],
//            [
//                'name' => $this->name,
//                'desc' => $this->desc,
//                'icon_path' => $this->icon
//            ])->id;
    }

    public abstract function qualify(User $user);
}
