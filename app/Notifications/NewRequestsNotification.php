<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class NewRequestsNotification extends Notification
{
    use Queueable;

    protected $departmentName;
    protected $prof;

    protected $module;


    public function __construct($prof, $module)
    {

            $this->prof = $prof;
            $this->module = $module;


            
    }
   
    

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {

            return [
                'message' => " Le professeur {$this->prof->firstname } {$this->prof->lastname } a demandé le module {$this->module->name }.",
                
                'url' => route('demandes.list'), 
                
            ];
       
        
    }
}
