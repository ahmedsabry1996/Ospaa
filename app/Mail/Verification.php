<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class Verification extends Mailable
{
    use Queueable, SerializesModels;


    public function __construct($code)
    {
    
 $this->code  = $code;

    }

    public function build()
    {
        return $this->view('email.sendcode',['code',$this->code])->from('no-reply@ospaa.com');
    }
}
