<?php

namespace App\Achievement;

use Illuminate\Support\Collection;

class Achievements extends Collection
{
    public function register($name, $handle, $icon) {
         $this->push((object) compact('name', 'handle', 'icon'));
    }
}
