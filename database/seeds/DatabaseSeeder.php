<?php

use Illuminate\Database\Seeder;
use App\Administrateur;
use App\Categorie;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        Administrateur::firstOrCreate(
            ['email' => 'admin@billetterie.com'],
            [
                'nom'          => 'Administrateur',
                'email'        => 'admin@billetterie.com',
                'mot_de_passe' => Hash::make('admin123'),
            ]
        );

        $categories = [
            ['nom' => 'Concert',    'description' => 'Concerts et spectacles musicaux'],
            ['nom' => 'Sport',      'description' => 'Événements sportifs'],
            ['nom' => 'Théâtre',    'description' => 'Pièces de théâtre et spectacles'],
            ['nom' => 'Conférence', 'description' => 'Conférences et séminaires'],
            ['nom' => 'Festival',   'description' => 'Festivals et fêtes culturelles'],
            ['nom' => 'Exposition', 'description' => 'Expositions artistiques'],
            ['nom' => 'Formation',  'description' => 'Ateliers et formations'],
            ['nom' => 'Autre',      'description' => 'Autres types d\'événements'],
        ];

        foreach ($categories as $cat) {
            Categorie::firstOrCreate(['nom' => $cat['nom']], $cat);
        }
    }
}
