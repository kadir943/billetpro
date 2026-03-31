<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Billet extends Model
{
    protected $table = 'billets';

    protected $fillable = [
        'client_id', 'evenement_id', 'numero_billet',
        'code_qr', 'statut', 'quantite', 'prix_unitaire'
    ];

    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }

    public function evenement()
    {
        return $this->belongsTo(Evenement::class, 'evenement_id');
    }

    public function paiement()
    {
        return $this->hasOne(Paiement::class, 'billet_id');
    }

    public function verifications()
    {
        return $this->hasMany(VerificationBillet::class, 'billet_id');
    }

    public function montantTotal()
    {
        return $this->prix_unitaire * $this->quantite;
    }
}
