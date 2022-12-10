<?php

namespace App\Models;

use App\Achievement\CustomCollection\Achievements;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Achievement extends Model
{
    use HasFactory;

    public function newCollection(array $models = [])
    {
        return new Achievements($models);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'achievement_user');
    }

    public function awardTo(User $user)
    {
        $this->users()->attach($user);
    }

    public function levelAsNumber()
    {
        return ['beginner' => 1, 'intermediate' => 2, 'advanced' => 3][$this->level];
    }
}
