<?php
namespace App;
use Illuminate\Database\Eloquent\Model;

class HistoriquePaiement extends Model
{
    protected $table = 'historique_paiements';
    protected $fillable = ['paiement_id', 'statut', 'date_modification'];
    protected $dates = ['date_modification'];

    public function paiement() { return $this->belongsTo(Paiement::class, 'paiement_id'); }
}
