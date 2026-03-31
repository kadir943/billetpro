<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ResetPasswordCode extends Mailable
{
    use Queueable, SerializesModels;

    public $nom;
    public $code;

    public function __construct($nom, $code)
    {
        $this->nom  = $nom;
        $this->code = $code;
    }

    public function build()
    {
        return $this->subject('Code de réinitialisation - BilletPro')
                    ->view('emails.reset_password_code');
    }
}