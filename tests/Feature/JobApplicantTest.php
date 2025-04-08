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

class JobApplicantTest extends TestCase
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
    public function admin_can_send_bulk_emails_to_applicants()
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

        // Assert notifications were sent
        Notification::assertSentTo(
            $this->applicants->take(2)->pluck('user'),
            BulkJobApplicantEmail::class,
            function ($notification, $channels) {
                return $notification->subject === 'Test Subject' &&
                       $notification->message === 'Test Message' &&
                       in_array('mail', $channels);
            }
        );
    }

    /** @test */
    public function admin_can_update_applicant_status()
    {
        // Acting as admin
        $this->actingAs($this->admin);

        // Get first applicant
        $applicant = $this->applicants->first();

        // Update status
        $response = $this->put(route('job-applicants.update-status', $applicant->id), [
            'status' => 'accepted'
        ]);

        // Assert response
        $response->assertRedirect()
            ->assertSessionHas('success');

        // Assert database was updated
        $this->assertDatabaseHas('job_applicants', [
            'id' => $applicant->id,
            'status' => 'accepted'
        ]);
    }

    /** @test */
    public function non_admin_cannot_send_bulk_emails()
    {
        // Create a regular user
        $user = User::factory()->create([
            'role' => 'user'
        ]);

        // Acting as regular user
        $this->actingAs($user);

        // Try to send bulk email
        $response = $this->post(route('job-applicants.send-bulk-email', $this->jobPost), [
            'subject' => 'Test Subject',
            'message' => 'Test Message',
            'applicants' => [$this->applicants->first()->id]
        ]);

        // Assert unauthorized
        $response->assertStatus(403);

        // Assert no notifications were sent
        Notification::assertNothingSent();
    }

    /** @test */
    public function bulk_email_requires_valid_data()
    {
        // Acting as admin
        $this->actingAs($this->admin);

        // Try to send bulk email with invalid data
        $response = $this->post(route('job-applicants.send-bulk-email', $this->jobPost), [
            'subject' => '', // Empty subject
            'message' => '', // Empty message
            'applicants' => [] // Empty applicants
        ]);

        // Assert validation errors
        $response->assertSessionHasErrors(['subject', 'message', 'applicants']);

        // Assert no notifications were sent
        Notification::assertNothingSent();
    }
} 