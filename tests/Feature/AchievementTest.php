<?php

namespace Tests\Feature;

use App\Models\Achievement;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use function PHPUnit\Framework\assertCount;

class AchievementTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_be_assigned_any_achievement_badge()
    {
        $user = User::factory()->create();
        $achievement = Achievement::factory()->create();
        $achievement->awardTo($user);

        assertCount(1, $user->achievements);
        self::assertTrue($user->achievements->contains($achievement));
    }
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_achievement_badge_is_unlock_once_a_user_experience_points_pass_1000()
    {
        $user = User::factory()->create();

        $user->awardExperience(1001);

        self::assertCount(1, $user->achievements());
    }
}