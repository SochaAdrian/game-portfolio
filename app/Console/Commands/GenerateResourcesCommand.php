<?php

namespace App\Console\Commands;

use App\Jobs\GenerateResourcesJob;
use App\Models\User;
use Illuminate\Console\Command;

class GenerateResourcesCommand extends Command
{
    protected $signature = 'resources:generate';

    protected $description = 'Generate resources for all users based on their buildings';

    public function handle(): void
    {
        $users = User::all();

        foreach($users as $user){
            GenerateResourcesJob::dispatch($user);
        }

        $this->info('Resources generate for all users jobs dispatched');
    }
}
