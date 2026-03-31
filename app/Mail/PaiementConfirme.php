<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PaiementConfirme extends Mailable
{
    use Queueable, SerializesModels;

    public $nom;
    public $evenement;
    public $numeroBillet;
    public $montant;

    public function __construct($nom, $evenement, $numeroBillet, $montant)
    {
        $this->nom          = $nom;
        $this->evenement    = $evenement;
        $this->numeroBillet = $numeroBillet;
        $this->montant      = $montant;
    }

    public function build()
    {
        return $this->subject('Votre billet est confirmé ! - BilletPro')
                    ->view('emails.paiement_confirme');
    }
}