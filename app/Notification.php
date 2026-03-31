<?php
namespace App;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $table = 'notifications';
    protected $fillable = ['client_id', 'message', 'date_envoi', 'statut'];
    protected $dates = ['date_envoi'];

    public function client() { return $this->belongsTo(Client::class, 'client_id'); }
}
