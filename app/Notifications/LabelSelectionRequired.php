<?php

namespace App\Notifications;

use App\Models\Submission;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class LabelSelectionRequired extends Notification
{
    use Queueable;

    public $submission;

    /**
     * Create a new notification instance.
     */
    public function __construct(Submission $submission)
    {
        $this->submission = $submission;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the database representation of the notification.
     */
    public function toDatabase(object $notifiable): array
    {
        return [
            'submission_id' => $this->submission->id,
            'submission_no' => $this->submission->submission_no,
            'title' => 'Label Selection Required',
            'message' => 'The cards for submission #' . $this->submission->submission_no . ' have been graded. Please select labels.',
            'url' => route('user.submissions.labels', $this->submission->id),
            'type' => 'info'
        ];
    }
}
