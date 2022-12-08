<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Achievement extends Model
{
    use HasFactory;

    public function users()
    {
        return $this->belongsToMany(User::class, 'achievement_user');
    }

    public function awardTo(User $user)
    {
//        DB::listen(function ($sql) use($user) {
//
//            var_dump($sql);
//        });
        $this->users()->attach($user);
    }
}
