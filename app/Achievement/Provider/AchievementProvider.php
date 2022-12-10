<?php

namespace App\Achievement\Provider;

use App\Achievement\Achievements;
use App\Achievement\Badge\FirstThousandPoint;
use App\Achievement\Badge\FiveThousandPoint;
use App\Achievement\Badge\FourThousandPoint;
use App\Achievement\Badge\MasteryBadge;
use App\Achievement\Badge\ThreeThousandPoint;
use App\Achievement\Badge\TwoThousandPoint;
use App\Achievement\Console\GenerateAchievementCommand;
use App\Achievement\Console\SeedUserAchievement;
use App\Achievement\Events\CalculateUserExperience;
use App\Achievement\Listeners\CheckAchivementBadge;
use App\Models\Achievement;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

class AchievementProvider extends ServiceProvider
{
    protected $achievements = [
        FirstThousandPoint::class,
        TwoThousandPoint::class,
        ThreeThousandPoint::class,
        FourThousandPoint::class,
        MasteryBadge::class,
        FiveThousandPoint::class
    ];

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('achievements', function () {
            $achievements = collect();
            foreach ($this->achievements as $achievement) {
                $achievements->push(resolve($achievement));
            }
            //Use \Illuminate\Support\Facades\Cache::forget('achievements') to remove the cache manually when update the achievement class
            //so can update the cache and DB from achievements class;
            return Cache::rememberForever(app()->environment('test') ? 'test_achievements' : 'achievements', function () use($achievements) {
               return $this->syncToAchievementTable($achievements);
            });

        });
    }

    private function syncToAchievementTable($achievements)
    {
        $upsertData = $achievements->map(function ($achievement){
            return [
                'class_name' => class_basename($achievement),
                'name' => $achievement->name,
                'desc' => $achievement->desc,
                'icon_path' => $achievement->icon,
                'level' => $achievement->level
            ];
        })->toArray();

       Achievement::query()->upsert($upsertData, ['class_name'], ['name', 'desc', 'icon_path', 'level']);
        $data = Achievement::all(['id', 'class_name']);
        return $achievements->map(function ($achievement) use ($data){
           $achievement->id = $this->getId($data, $achievement);

           return $achievement;
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Event::listen(CalculateUserExperience::class, CheckAchivementBadge::class);
        $this->commands([GenerateAchievementCommand::class, SeedUserAchievement::class]);
    }

    /**
     * @param \Illuminate\Database\Eloquent\Collection $data
     * @param $achievement
     * @return mixed
     */
    function getId(\Illuminate\Database\Eloquent\Collection $data, $achievement)
    {
        return $data->where('class_name', class_basename($achievement))->first()->id;
    }
}
