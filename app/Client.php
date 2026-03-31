<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Client extends Authenticatable
{
    use Notifiable;

    protected $table = 'clients';

protected $fillable = ['nom', 'email', 'mot_de_passe', 'telephone', 'statut', 'photo'];

    protected $hidden = ['mot_de_passe', 'remember_token'];

    public function getAuthPassword()
    {
        return $this->mot_de_passe;
    }

    public function billets()
    {
        return $this->hasMany(Billet::class, 'client_id');
    }

    public function avis()
    {
        return $this->hasMany(Avis::class, 'client_id');
    }

    public function favoris()
    {
        return $this->hasMany(Favori::class, 'client_id');
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class, 'client_id');
    }
}
