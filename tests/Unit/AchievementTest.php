<?php

namespace Tests\Unit;

use App\Achievement\Badge\Achievement;
use App\Models\Achievement as AchievementModel;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use function PHPUnit\Framework\assertEquals;

class AchievementTest extends TestCase
{
    use RefreshDatabase;

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
    /**
     * @param User $user
     * @return mixed
     */
    public function qualify(User $user)
    {
        // TODO: Implement qualify() method.
    }
}
