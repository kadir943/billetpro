<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employe extends Model
{
    protected $table = 'employes';

    protected $fillable = [
        'nom',
        'email',
        'mot_de_passe',
        'telephone',
        'role',
        'statut',
    ];

    protected $hidden = ['mot_de_passe'];
}