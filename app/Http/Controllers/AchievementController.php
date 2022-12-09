<?php

namespace App\Http\Controllers;

use App\Models\User;

class AchievementController extends Controller
{
    public function achievement()
    {
        $awardAchievements = User::first()->achievements;
        $achievements = resolve('achievements');
//        return view('welcome');
        return view('achievement', compact('awardAchievements', 'achievements'));
    }
}
