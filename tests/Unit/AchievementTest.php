<?php

namespace Tests\Unit;

use App\Achievement\Badge\Achievement;
use App\Achievement\Badge\FirstThousandPoint;
use App\Achievement\CustomCollection\Achievements;
use App\Models\Achievement as AchievementModel;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use function PHPUnit\Framework\assertCount;
use function PHPUnit\Framework\assertEquals;

class AchievementTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_sort_achievements_according_to_a_skill_level()
    {
        AchievementModel::factory()->create(['level' => 'advanced']);
        AchievementModel::factory()->create(['level' => 'intermediate']);
        AchievementModel::factory()->create(['level' => 'beginner']);
        $achievements = AchievementModel::all()->sortbyLevel();
        assertEquals($achievements->pluck('level')->toArray(), ['beginner', 'intermediate', 'advanced']);

        $achievements = AchievementModel::all()->sortbyLevel(asc: false);
        assertEquals($achievements->pluck('level')->toArray(), ['advanced', 'intermediate', 'beginner']);
    }

    public function test_it_can_persist_achievement_class_attribute_in_database()
    {
        $achievement = new FirstThousandPoint();
        resolve('achievements');

        $this->assertDatabaseHas('achievements', [
            'name' => $achievement->name,
            'desc' => $achievement->desc,
            'icon_path' => $achievement->icon,
            'class_name' => 'FirstThousandPoint',
            'level' => $achievement->level
        ]);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_it_has_a_name()
    {
        $achievement = AchievementModel::factory()->create([
            'name' => 'move-up-to'
        ]);
        self::assertEquals($achievement->name, 'move-up-to');
    }

    public function test_it_has_desc()
    {
        $achievement = AchievementModel::factory()->create([
            'desc' => 'move-up-to-desc'
        ]);
        self::assertEquals($achievement->desc, 'move-up-to-desc');
    }

    public function test_it_has_icon()
    {
        $achievement = AchievementModel::factory()->create([
            'icon_path' => 'move-up-to.svg'
        ]);
        self::assertEquals('move-up-to.svg', $achievement->icon_path);
    }

    public function test_set_a_default_name()
    {
        $achievement = new FakeAchievement();
        assertEquals($achievement->name, 'Fake Achievement');
    }

    public function test_can_set_name()
    {
        $achievement = new FakeAchievementName();
        assertEquals($achievement->name, 'Fake Name Custom');
    }

    public function test_set_a_default_icon()
    {
        $achievement = new FakeAchievement();
        assertEquals($achievement->icon, 'fake-achievement.svg');
    }

    public function test_can_set_icon()
    {
        $achievement = new FakeAchievementName();
        assertEquals($achievement->icon, 'fake-icon.svg');
    }

    public function test_set_a_default_skill_level()
    {
        $achievement = new FakeAchievement();
        assertEquals($achievement->level, 'intermediate');
    }

    public function test_can_set_skill_level()
    {
        $achievement = new FakeAchievementName();
        assertEquals($achievement->level, 'advanced');
    }

    public function test_it_return_a_custom_achievements_collection()
    {
        self::assertInstanceOf(Achievements::class, AchievementModel::all());
    }

    public function test_it_can_filter_achievements_for_given_user()
    {
        $user = User::factory()->create();
        assertCount(0, \App\Models\Achievement::all()->for($user));
        $user->awardExperience(1000);
        assertCount(1, \App\Models\Achievement::all()->for($user->fresh()));
        $user->awardExperience(1000);
        assertCount(2, \App\Models\Achievement::all()->for($user->fresh()));
    }

    public function test_it_can_filter_remaining_achievements_for_given_user()
    {
        $user = User::factory()->create();
        $user->awardExperience(2000);
        assertCount(4, \App\Models\Achievement::all()->remainingFor($user));
    }
}

class FakeAchievement extends Achievement
{
    public $desc = 'This is fake desc';
    /**
     * @param User $user
     * @return mixed
     */
    public function qualify(User $user)
    {
        // TODO: Implement qualify() method.
    }
}
class FakeAchievementName extends Achievement
{
    public $name = 'Fake Name Custom';
    public $desc = 'This is fake desc';
    public $icon = 'fake-icon.svg';
    public $level = 'advanced';
    /**
     * @param User $user
     * @return mixed
     */
    public function qualify(User $user)
    {
        // TODO: Implement qualify() method.
    }
}
