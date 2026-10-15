<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GroupeEtudiantController extends Controller
{
    public function createGroupe(Request $request)
    {
        $etudiants = $request->etudiants;
        $nombrePersonneParGroupe = $request->nombrePersonneParGroupe;

        $nombreGroupe = ceil(count($etudiants) / $nombrePersonneParGroupe);

        // dd($nombreGroupe);
        $groupes = [];
        for ($i = 0; $i < $nombreGroupe; $i++) {
            $groupes[$i] = [];
        }

        // dd(count($groupes));

        //on parcour la liste des arrays puis a chaque array on fait un shuflle et on ajoute jusqua atteindre le nombre de personne par groupe et on passe au groupe suivant
        for ($i = 0; $i < count($groupes); $i++) {
            // dd(count($groupes[$i]));die;
            while (count($groupes[$i]) < $nombrePersonneParGroupe && count($etudiants) > 0) {
                shuffle($etudiants);
                $groupes[$i][] = $etudiants[0];

                unset($etudiants[0]);
            }
        }
    }
}
