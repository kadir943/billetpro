<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Organisateur extends Authenticatable
{
    use Notifiable;

    protected $table = 'organisateurs';

  protected $fillable = [
    'nom',
    'nom_organisation',
    'type_organisation',
    'email',
    'mot_de_passe',
    'telephone',
    'telephone_pro',
    'numero_ifu',
    'photo_identite',
    'photo',
    'statut',
];
    protected $hidden = ['mot_de_passe', 'remember_token'];

    public function getAuthPassword()
    {
        return $this->mot_de_passe;
    }

    public function evenements()
    {
        return $this->hasMany(Evenement::class, 'organisateur_id');
    }
}
