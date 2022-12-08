<?php

namespace Tests\Feature;

use App\Achievement\Events\Events\UserEarnExperience;
use App\Models\Lesson;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class ExperienceTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_it_earn_point_when_complete_lesson()
    {
        $user = User::factory()->create();
        $lesson = Lesson::factory()->create();
        $user->completeLesson($lesson);

        self::assertEquals($lesson->point, $user->fresh()->point);
    }

    public function test_user_an_announcement_is_made_when_experience_is_earn()
    {
        Event::fake();

        $user = User::factory()->create();
        $lesson = Lesson::factory()->create();
        $user->completeLesson($lesson);

        Event::assertDispatched(UserEarnExperience::class, function ($event) use($user, $lesson) {
            return $event->user->is($user) && $event->earnPoint === $lesson->point;
        });
    }
}
