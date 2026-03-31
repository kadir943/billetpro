<?php
namespace App;
use Illuminate\Database\Eloquent\Model;

class Statistique extends Model
{
    protected $table = 'statistiques';
    protected $fillable = ['evenement_id', 'billets_vendus', 'revenu_total'];

    public function evenement() { return $this->belongsTo(Evenement::class, 'evenement_id'); }
}
