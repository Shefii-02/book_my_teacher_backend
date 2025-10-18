<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendOtpMail extends Mailable
{
    use Queueable, SerializesModels;

    public $otp;
    public $expTime;

    public function __construct($otp, $expTime)
    {
        $this->otp = $otp;
        $this->expTime = $expTime;
    }

    public function build()
    {
        return $this->subject('Your OTP for BookMyTeacher')
                    ->view('emails.otp')
                    ->with([
                        'otp' => $this->otp,
                        'expTime' => $this->expTime,
                    ]);
    }
}
