<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CompteApprouve extends Mailable
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
        return $this->subject('Votre compte BilletPro est activé !')
                    ->view('emails.compte_approuve');
    }
}