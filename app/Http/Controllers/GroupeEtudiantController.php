<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GroupeEtudiantController extends Controller
{
    public function createGroupe(Request $request)
    {
        $etudians = $request->etudiants;
        $nombrePersonneParGroupe = $request->nombrePersonneParGroupe;

        $nombreGroupe = count($etudians) / $nombrePersonneParGroupe;

        $groupes = [];
        for ($i = 0; $i < $nombreGroupe; $i++) {
            $groupes[$i] = [];
        }

        //on parcour la liste des arrays puis a chaque array on fait un shuflle et on ajoute jusqua atteindre le nombre de personne par groupe et on passe au groupe suivant
        for ($i = 0; $i < count($groupes); $i++) {
            // dd(count($groupes[$i]));die;
            while (count($groupes[$i]) < $nombrePersonneParGroupe) {
                shuffle($etudians);
                $groupes[$i][] =$etudians[0];

                unset($etudians[0]);
            }
        }

        dd($groupes);
        die;
    }
}
