<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ProfUnassignedNotification extends Notification
{
    use Queueable;

    protected $departmentName;

    protected $filiereName;

    public function __construct($Name, $isdepartment, $isfiliere)
    {
        if ($isdepartment) {

            $this->departmentName = $Name;
        } elseif ($isfiliere) {

            $this->filiereName = $Name;

        }
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        if ($this->departmentName) {

            return [
                'message' => "La departement '{$this->departmentName}' n'est attribué à aucun professeur.",

                'url' => route('departements.list'), // Replace with your desired route

            ];
        } elseif ($this->filiereName) {
            return [
                'message' => "Le filières '{$this->filiereName}' n'est attribué à aucun professeur.",

                'url' => route('filieres.list'), // Replace with your desired route

            ];

        }
    }
}
