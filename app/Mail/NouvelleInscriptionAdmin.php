<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NouvelleInscriptionAdmin extends Mailable
{
    use Queueable, SerializesModels;

    public $nom;
    public $email;
    public $role;

    public function __construct($nom, $email, $role)
    {
        $this->nom   = $nom;
        $this->email = $email;
        $this->role  = $role;
    }

    public function build()
    {
        return $this->subject('Nouvelle inscription sur BilletPro - ' . ucfirst($this->role))
                    ->view('emails.nouvelle_inscription_admin');
    }
}