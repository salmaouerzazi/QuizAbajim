<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use App\User;

class UpdateLastSeenCommand extends Command
{
    protected $signature = 'users:update-last-seen';
    protected $description = 'Update last seen for active users every 5 minutes';

    public function handle()
    {
        User::whereNotNull('last_seen_at')
            ->where('last_seen_at', '>=', Carbon::now('Africa/Tunis')->subMinutes(5))
            ->update(['last_seen_at' => Carbon::now('Africa/Tunis')]);

        $this->info('User last seen times updated!');
    }
}

