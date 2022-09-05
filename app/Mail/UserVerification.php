<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserVerification extends Mailable
{
    use Queueable, SerializesModels;

    private $code;

    public function __construct($code)
    {
        $this->code = $code; // verification code
    }

    public function build()
    {
        return $this->from('sender@example.com')
                    ->subject('User Verification')
                    ->view('user-login-validation');
    }
}
