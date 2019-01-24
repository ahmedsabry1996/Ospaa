<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ReplyReprt extends Mailable
{
    use Queueable, SerializesModels;

	public $reply;
	
    public function __construct($reply)
    {
        $this->reply = $reply;
    }



    public function build()
    {
        return $this->view('email.report',['reply'=>$this->reply])->from('no-reply@ospaa.com');
    }

}
