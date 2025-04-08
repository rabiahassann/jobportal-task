<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Queue;

class ProcessEmailQueue extends Command
{
    protected $signature = 'queue:process-emails';
    protected $description = 'Process the email queue';

    public function handle()
    {
        $this->info('Starting email queue processing...');
        
        // Run the queue worker for the emails queue
        $this->call('queue:work', [
            '--queue' => 'emails',
            '--tries' => 3,
            '--timeout' => 60,
            '--max-jobs' => 100,
            '--max-time' => 3600,
            '--stop-when-empty' => true
        ]);
    }
} 