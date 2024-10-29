<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Models\Thread;
use App\Jobs\SendNotifications;
use Illuminate\Console\Command;

class NotifyCommand extends Command
{
    protected $description = 'Command description';

    protected $signature = 'notify:user';

    public function handle()
    {
        $user = User::first();
        $threads = Thread::latest()->take(2)->get();
        foreach ($threads as $thread) {
            $this->line('Send notifications for thread');
            SendNotifications::dispatch($user, $thread);
        }

        return Command::SUCCESS;
    }
}
