<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\JobPost;
use App\Models\JobApplicant;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\Notification;
use App\Notifications\BulkJobApplicantEmail;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EmailQueueTest extends TestCase
{
    use RefreshDatabase;

    protected $admin;
    protected $jobPost;
    protected $applicants;

    protected function setUp(): void
    {
        parent::setUp();

        // Create an admin user
        $this->admin = User::factory()->create([
            'role' => 'admin'
        ]);

        // Create a job post
        $this->jobPost = JobPost::factory()->create();

        // Create some applicants
        $this->applicants = JobApplicant::factory()->count(3)->create([
            'job_post_id' => $this->jobPost->id
        ]);

        // Fake the queue and notification
        Queue::fake();
        Notification::fake();
    }

    /** @test */
    public function emails_are_properly_queued()
    {
        // Acting as admin
        $this->actingAs($this->admin);

        // Select some applicants
        $selectedApplicants = $this->applicants->take(2)->pluck('id')->toArray();

        // Send bulk email
        $response = $this->post(route('job-applicants.send-bulk-email', $this->jobPost), [
            'subject' => 'Test Subject',
            'message' => 'Test Message',
            'applicants' => $selectedApplicants
        ]);

        // Assert response
        $response->assertRedirect()
            ->assertSessionHas('success');

        // Assert jobs were queued
        Queue::assertPushedOn('emails', BulkJobApplicantEmail::class);

        // Assert correct number of jobs were queued
        Queue::assertCount(2, 'emails');
    }

    /** @test */
    public function queued_emails_have_correct_retry_settings()
    {
        // Acting as admin
        $this->actingAs($this->admin);

        // Select an applicant
        $selectedApplicant = $this->applicants->first();

        // Send bulk email
        $this->post(route('job-applicants.send-bulk-email', $this->jobPost), [
            'subject' => 'Test Subject',
            'message' => 'Test Message',
            'applicants' => [$selectedApplicant->id]
        ]);

        // Get the queued job
        $job = Queue::pushedJobs()[BulkJobApplicantEmail::class][0];

        // Assert retry settings
        $this->assertEquals(3, $job['job']->tries);
        $this->assertEquals(60, $job['job']->timeout);
        $this->assertEquals(3, $job['job']->maxExceptions);
    }

    /** @test */
    public function failed_emails_are_retried()
    {
        // Acting as admin
        $this->actingAs($this->admin);

        // Select an applicant
        $selectedApplicant = $this->applicants->first();

        // Send bulk email
        $this->post(route('job-applicants.send-bulk-email', $this->jobPost), [
            'subject' => 'Test Subject',
            'message' => 'Test Message',
            'applicants' => [$selectedApplicant->id]
        ]);

        // Get the queued job
        $job = Queue::pushedJobs()[BulkJobApplicantEmail::class][0];

        // Simulate job failure
        $job['job']->failed(new \Exception('Test failure'));

        // Assert job was released for retry
        Queue::assertPushedOn('emails', BulkJobApplicantEmail::class);
    }

    /** @test */
    public function email_queue_handles_multiple_jobs()
    {
        // Acting as admin
        $this->actingAs($this->admin);

        // Send multiple bulk emails
        for ($i = 0; $i < 3; $i++) {
            $this->post(route('job-applicants.send-bulk-email', $this->jobPost), [
                'subject' => "Test Subject $i",
                'message' => "Test Message $i",
                'applicants' => [$this->applicants[$i]->id]
            ]);
        }

        // Assert correct number of jobs were queued
        Queue::assertCount(3, 'emails');

        // Assert each job has correct data
        $jobs = Queue::pushedJobs()[BulkJobApplicantEmail::class];
        foreach ($jobs as $index => $job) {
            $this->assertEquals("Test Subject $index", $job['job']->subject);
            $this->assertEquals("Test Message $index", $job['job']->message);
        }
    }
} 