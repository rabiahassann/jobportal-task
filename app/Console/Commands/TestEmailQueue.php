<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\JobPost;
use App\Models\JobApplicant;
use App\Notifications\BulkJobApplicantEmail;
use Illuminate\Support\Facades\Notification;

class TestEmailQueue extends Command
{
    protected $signature = 'test:email-queue';
    protected $description = 'Test the email queue functionality';

    public function handle()
    {
        $this->info('Starting email queue test...');

        // Get a job post and its applicants
        $jobPost = JobPost::first();
        if (!$jobPost) {
            $this->error('No job posts found. Please create a job post first.');
            return;
        }

        $applicants = JobApplicant::where('job_post_id', $jobPost->id)
            ->with('user')
            ->take(2)
            ->get();

        if ($applicants->isEmpty()) {
            $this->error('No applicants found for this job post.');
            return;
        }

        $this->info('Found ' . $applicants->count() . ' applicants to test with.');

        // Create and send notification
        $notification = new BulkJobApplicantEmail(
            'Test Email Subject',
            'This is a test email message for queue testing.'
        );

        try {
            Notification::send($applicants->pluck('user'), $notification);
            $this->info('Test emails have been queued successfully!');
            $this->info('Check your queue worker and email inbox.');
        } catch (\Exception $e) {
            $this->error('Failed to queue test emails: ' . $e->getMessage());
        }
    }
} 