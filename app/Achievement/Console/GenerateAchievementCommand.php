<?php

namespace App\Achievement\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;

class GenerateAchievementCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:achievement {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate a new achievement class stub';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try {
            $name = $this->argument('name');
            $content = File::get(app_path('Achievement/Console/achievement.stub'));
            $content = str_replace('{{CLASS}}', $name, $content);
            File::put(app_path($class = "Achievement/Badge/$name.php"), $content);

            Cache::forget('achievements');
        }catch (\Throwable $exception) {
            $this->error($exception->getMessage());

            return Command::FAILURE;
        }

        $this->info("$class class was generate successfully");

        return Command::SUCCESS;
    }
}
