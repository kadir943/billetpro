<?php
namespace App;
use Illuminate\Database\Eloquent\Model;

class Avis extends Model
{
    protected $table = 'avis';
    protected $fillable = ['client_id', 'evenement_id', 'note', 'commentaire'];

    public function client() { return $this->belongsTo(Client::class, 'client_id'); }
    public function evenement() { return $this->belongsTo(Evenement::class, 'evenement_id'); }
}
