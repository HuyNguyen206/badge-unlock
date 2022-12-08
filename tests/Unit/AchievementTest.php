<?php

namespace Tests\Unit;

use App\Models\Achievement;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

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
        $achievement = Achievement::factory()->create([
            'name' => 'move-up-to'
        ]);
        self::assertEquals($achievement->name, 'move-up-to');
    }

    public function test_it_has_desc()
    {
        $achievement = Achievement::factory()->create([
            'desc' => 'move-up-to-desc'
        ]);
        self::assertEquals($achievement->desc, 'move-up-to-desc');
    }

    public function test_it_has_icon()
    {
        $achievement = Achievement::factory()->create([
            'icon_path' => 'move-up-to.svg'
        ]);
        self::assertEquals('move-up-to.svg', $achievement->icon_path);
    }
}
