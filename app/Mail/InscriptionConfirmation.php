<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InscriptionConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public $nom;
    public $role;

    public function __construct($nom, $role)
    {
        $this->nom  = $nom;
        $this->role = $role;
    }

    public function build()
    {
        return $this->subject('Confirmation de votre inscription - BilletPro')
                    ->view('emails.inscription_confirmation');
    }
}