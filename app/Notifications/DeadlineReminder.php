<?php

namespace App\Notifications;

use App\Models\Deadline;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class DeadlineReminder extends Notification
{
    use Queueable;

    protected $deadline, $daysLeft;

    public function __construct(Deadline $deadline, int $daysLeft)
    {
        $this->deadline = $deadline;
        $this->daysLeft = $daysLeft;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $url = route('coordonnateur.groupes.next_semester');
        $filiere = $this->deadline->filiere ? $this->deadline->filiere->name : 'All';

        return (new MailMessage)
            ->subject('TD/TP Configuration Deadline')
            ->greeting("Hello {$notifiable->full_name},")
            ->line("Configure TD/TP groups for filière {$filiere} by {$this->deadline->deadline_date->format('Y-m-d')}.")
            ->line("{$this->daysLeft} days remaining.")
            ->action('Configure', $url);
    }
}