<?php

namespace App\Notifications;

use App\Models\Deadline;
use Illuminate\Notifications\Messages\DatabaseMessage;
use Illuminate\Notifications\Notification;

class DeadlineNotification extends Notification
{
    protected $message;
    protected $deadline;
    protected $url;

    public function __construct(string $message, Deadline $deadline, string $url)
    {
        $this->message = $message;
        $this->deadline = $deadline;
        $this->url = $url;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return new DatabaseMessage([
            'message' => $this->message,
            'deadline_id' => $this->deadline->id,
            'deadline_date' => $this->deadline->deadline_date->format('d/m/Y H:i'),
            'type' => $this->deadline->type,
            'url' => $this->url,
        ]);
    }
}
?>