<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Queue\SerializesModels;

class BulkJobApplicantEmail extends Notification implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $subject;
    public $message;
    public $tries = 3;
    public $timeout = 60;
    public $maxExceptions = 3;
    public $backoff = [30, 60, 120];

    public function __construct($subject, $message)
    {
        $this->subject = $subject;
        $this->message = $message;
        $this->onQueue('emails');
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject($this->subject)
            ->markdown('emails.bulk-applicant', [
                'message' => $this->message,
                'applicant' => $notifiable,
                'subject' => $this->subject
            ]);
    }

    public function toArray($notifiable)
    {
        return [
            'subject' => $this->subject,
            'message' => $this->message
        ];
    }

    public function retryUntil()
    {
        return now()->addMinutes(10);
    }
} 