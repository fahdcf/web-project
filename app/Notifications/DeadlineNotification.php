<?php

namespace App\Notifications;

use App\Models\Deadline;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\DatabaseMessage;
use Illuminate\Notifications\Notification;

class DeadlineNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $message;
    protected $deadline;

    /**
     * Create a new notification instance.
     */
    public function __construct(string $message, Deadline $deadline)
    {
        $this->message = $message;
        $this->deadline = $deadline;
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the database representation of the notification.
     */
    public function toDatabase($notifiable)
    {
        return new DatabaseMessage([
            'message' => $this->message,
            'deadline_id' => $this->deadline->id,
            'deadline_date' => $this->deadline->deadline_date->format('d/m/Y H:i'),
            'type' => $this->deadline->type,
        ]);
    }
}