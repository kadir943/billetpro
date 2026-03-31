<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Paiement extends Model
{
    protected $table = 'paiements';

   protected $fillable = [
    'billet_id',
    'montant',
    'methode_paiement',
    'statut_paiement',
    'date_paiement',
    'reference',
    'recu_paiement',
    'code_transaction',
    'employe_id',
    'date_verification',
];

    protected $dates = ['date_paiement'];

    public function billet()
    {
        return $this->belongsTo(Billet::class, 'billet_id');
    }

    public function historique()
    {
        return $this->hasMany(HistoriquePaiement::class, 'paiement_id');
    }
}
