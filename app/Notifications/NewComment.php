<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class NewComment extends Notification
{
    use Queueable;



     //commenter_id
     public $commenter_id;

     //ads id
     public $ads_id;

     //ads title
     public $ads_title;

    public function __construct($commenter,$ad_id,$ads_title)
    {
        
        $this->commenter_id = $commenter;
        $this->ads_id = $ad_id;
        $this->ads_title = $ads_title;

    }


    public function via($notifiable)
    {
        return ['database'];
    }



    public function toArray($notifiable)
    {
        return [
              
             'commenter_id'=>$this->commenter_id,
             'ads_id'=>$this->ads_id,
             'ads_title'=>$this->ads_title,
             'message'=>'يوجد تعليق جديد على اعلانك'       
        ];
    }
}
