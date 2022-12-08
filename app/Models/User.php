<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Achievement\Achievements;
use App\Events\UserEarnExperience;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function completeLesson($lesson)
    {
        $this->lessons()->attach($lesson);
        $this->awardExperience($lesson->point);
        event(new UserEarnExperience($this, $lesson->point));
    }

    public function awardExperience(int $point)
    {
        $this->increment('point', $point);
    }

    public function lessons()
    {
        return $this->belongsToMany(Lesson::class, 'user_lesson');
    }

    public function achievements()
    {
        return resolve(Achievements::class)->filter(function ($badge){
            return call_user_func($badge->handle, $this);
        });

//        return $this->belongsToMany(Achievement::class, 'achievement_user');
    }

    public function awardAchievement($achievement)
    {

        $this->achievements()->attach($achievement);
    }
}
