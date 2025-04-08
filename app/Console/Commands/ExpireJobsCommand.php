<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\JobPost;
use Carbon\Carbon;

class ExpireJobsCommand extends Command
{
    protected $signature = 'jobs:expire';
    protected $description = 'Expire jobs that have passed their deadline';

    public function handle()
    {
        $this->info('Starting job expiration process...');

        $expiredJobs = JobPost::where('status', 'active')
            ->where('applied_before', '<', Carbon::now())
            ->get();

        $count = $expiredJobs->count();

        if ($count > 0) {
            foreach ($expiredJobs as $job) {
                $job->update(['status' => 'expired']);
                $this->info("Job '{$job->title}' has been expired.");
            }
            $this->info("Successfully expired {$count} jobs.");
        } else {
            $this->info('No jobs to expire.');
        }
    }
} 