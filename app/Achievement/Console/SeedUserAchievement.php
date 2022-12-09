<?php

namespace App\Achievement\Console;

use App\Models\User;
use Illuminate\Console\Command;

class SeedUserAchievement extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'users:seed-achievements';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Seed achievement for all user';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        foreach (User::query()->cursor() as $user) {
            $this->info("Seeding user $user->email");
            $achievementsToAwardUser = resolve('achievements')
                ->filter->qualify($user)
                ->pluck('id');

            $user->achievements()->sync($achievementsToAwardUser);
        }

        return Command::SUCCESS;
    }
}
