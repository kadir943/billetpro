<?php
namespace App;
use Illuminate\Database\Eloquent\Model;

class VerificationBillet extends Model
{
    protected $table = 'verification_billets';
    protected $fillable = ['billet_id', 'verifie_par', 'date_verification', 'statut'];
    protected $dates = ['date_verification'];

    public function billet() { return $this->belongsTo(Billet::class, 'billet_id'); }
    public function organisateur() { return $this->belongsTo(Organisateur::class, 'verifie_par'); }
}
