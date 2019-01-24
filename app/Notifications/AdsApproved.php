<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class AdsApproved extends Notification
{
    use Queueable;


    public $message;
    public $ads_id;
    public $ads_title;

    public function __construct($msg,$ad_id,$ad_title)
    {
        $this->message = $msg;
        $this->ads_id = $ad_id;
        $this->ads_title = $ad_title;
    
    }


    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        return [
            
            'message'=>$this->message,
            'ads_id'=>$this->ads_id,
            'ads_title'=>$this->ads_title

        ];
    }
}
