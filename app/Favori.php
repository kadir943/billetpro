<?php
namespace App;
use Illuminate\Database\Eloquent\Model;

class Favori extends Model
{
    protected $table = 'favoris';
    protected $fillable = ['client_id', 'evenement_id'];

    public function client() { return $this->belongsTo(Client::class, 'client_id'); }
    public function evenement() { return $this->belongsTo(Evenement::class, 'evenement_id'); }
}
