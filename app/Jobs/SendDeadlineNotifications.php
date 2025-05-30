<?php

namespace App\Jobs;

use App\Models\Deadline;
use App\Models\User;
use App\Notifications\DeadlineReminder;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Notifications\Notification;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendDeadlineNotifications implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle()
    {
        $deadlines = Deadline::query()
            ->where('type', 'td_tp_configuration')
            ->where('notification_date', '<=', now())
            ->where('deadline_date', '>=', now())
            ->where('status', 'active')
            ->get();

        foreach ($deadlines as $deadline) {
            $daysLeft = now()->diffInDays($deadline->deadline_date);
            if (!in_array($daysLeft, [14, 7, 3])) {
                continue;
            }

            $coordinators = User::where('role', 'coordonnateur')
                ->where('filiere_id', $deadline->filiere_id)
                ->get();

            foreach ($coordinators as $coordinator) {
                $coordinator->notify(new DeadlineReminder($deadline));

                Notification::create([
                    'deadline_id' => $deadline->id,
                    'user_id' => $coordinator->id,
                    'type' => 'email',
                    'message' => "Reminder: Configure TD/TP groups for {$deadline->semester} by {$deadline->deadline_date->format('Y-m-d')}",
                    'sent_at' => now(),
                    'status' => 'sent',
                ]);
            }
        }
    }
}