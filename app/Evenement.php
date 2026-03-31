<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Evenement extends Model
{
    protected $table = 'evenements';

    protected $fillable = [
        'titre', 'description', 'date_evenement', 'lieu',
        'prix', 'capacite', 'places_disponibles', 'image',
        'organisateur_id', 'categorie_id', 'statut'
    ];

    protected $dates = ['date_evenement'];

    public function organisateur()
    {
        return $this->belongsTo(Organisateur::class, 'organisateur_id');
    }

    public function categorie()
    {
        return $this->belongsTo(Categorie::class, 'categorie_id');
    }

    public function billets()
    {
        return $this->hasMany(Billet::class, 'evenement_id');
    }

    public function avis()
    {
        return $this->hasMany(Avis::class, 'evenement_id');
    }

    public function favoris()
    {
        return $this->hasMany(Favori::class, 'evenement_id');
    }

    public function statistique()
    {
        return $this->hasOne(Statistique::class, 'evenement_id');
    }

 public function noteMoyenne()
{
    $note = $this->avis()->avg('note');
    return $note ? $note : 0;
}
}