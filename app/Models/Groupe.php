<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Groupe extends Model
{
    protected $fillable = ['nom', 'statut'];

    public function etudiants()
    {
        return $this->belongsToMany(
            Etudiant::class,
            'groupe_etudiants',
            'groupe_id',
            'etudiant_id'
        )->withTimestamps();
    }
}
