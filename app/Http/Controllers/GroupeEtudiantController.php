<?php

namespace App\Http\Controllers;

use App\Models\Etudiant;
use App\Models\Groupe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GroupeEtudiantController extends Controller
{
    // private $groupes = [];
    public function store(Request $request)
    {
        $etudiants = $request->etudiants;
        $nombrePersonneParGroupe = $request->nombrePersonneParGroupe;

        $newGroupes = $this->createGroupe($nombrePersonneParGroupe, $etudiants);

        foreach ($newGroupes as &$groupe) {
            $groupe['nom'] = $this->createGroupeName($groupe);
            $groupe['nom'] = implode('', $groupe['nom']);
        }

        // dd($newGroupes);

        try {
            DB::beginTransaction();
            //  changer tout les groupe qui etait active a inactive
            $this->archiveOldGroupe();

            //creation des nouveau groupe
            $this->creationDeGroupeMembre($newGroupes);
            DB::commit();
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    function createGroupe(int $nombrePersonneParGroupe, array $etudiants)
    {
        $nombreGroupe = ceil(count($etudiants) / $nombrePersonneParGroupe);

        // dd($nombreGroupe);
        $groupes = [];
        for ($i = 0; $i < $nombreGroupe; $i++) {
            $groupes[$i] = [];
        }

        //on parcour la liste des arrays puis a chaque array on fait un shuflle et on ajoute jusqua atteindre le nombre de personne par groupe et on passe au groupe suivant
        for ($i = 0; $i < count($groupes); $i++) {
            // dd(count($groupes[$i]));die;
            while (count($groupes[$i]) < $nombrePersonneParGroupe && count($etudiants) > 0) {
                shuffle($etudiants);
                $groupes[$i][] = $etudiants[0];

                unset($etudiants[0]);
            }
        }

        return $groupes;
    }

    function archiveOldGroupe()
    {
        $oldGroupe = Groupe::where('statut', 1)->get();
        foreach ($oldGroupe as  $g) {
            $g->statut = 0;
            $g->save();
        }
    }

    function createGroupeName(array $groupe)
    {
        $lettres = [];
        //a chaque tour de boucle je recupere la premiere lettre
        foreach ($groupe as  $membres) {
            $lettres[] =  $membres["nomComplet"][0];
        }
        //  dd($lettres);

        return $lettres;
    }

    function creationDeGroupeMembre(array $newGroupe)
    {
    
        foreach ($newGroupe as $groupe) {
            Groupe::create([
                'nom'    => $groupe['nom'],
                'statut' => 1,
            ]);
        }
    }
}
