<?php

namespace App\Http\Controllers;

use App\Models\Groupe;
use App\Models\GroupeEtudiant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GroupeEtudiantController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'nombrePersonneParGroupe' => 'required|integer'
        ]);
        
        $etudiants = $request->etudiants;
        $nombrePersonneParGroupe = $request->nombrePersonneParGroupe;

        $newGroupes = $this->createGroupe($nombrePersonneParGroupe, $etudiants);

        DB::beginTransaction();
        foreach ($newGroupes as &$groupe) {
            $groupe['nom'] = $this->createGroupeName($groupe);
            $groupe['nom'] = implode('', $groupe['nom']);
        }

        try {
            //  changer tout les groupe qui etait active a inactive
            $this->archiveOldGroupe();

            //creation des nouveau groupe
            $this->creationDeGroupeMembre($newGroupes);
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
        }
    }

    function createGroupe(int $nombrePersonneParGroupe, array $etudiants)
    {
        $nombreGroupe = ceil(count($etudiants) / $nombrePersonneParGroupe);
        $sommeDesNiveau = $this->sommeDesNiveau($etudiants);
        $moyenNiveau = $sommeDesNiveau / $nombreGroupe; 


        // dd($moyenNiveau);
        $groupes = [];
        for ($i = 0; $i < $nombreGroupe; $i++) {
            $groupes[$i] = [];
        }

        //on parcour la liste des arrays puis a chaque array on fait un shuflle et on ajoute jusqua atteindre le nombre de personne par groupe et on passe au groupe suivant
        for ($i = 0; $i < count($groupes); $i++) {
            while (count($groupes[$i]) < $nombrePersonneParGroupe && count($etudiants) > 0) {
                shuffle($etudiants);
                $groupes[$i][] = $etudiants[0];

                unset($etudiants[0]);
            }
        }

        return $groupes;
    }

    function sommeDesNiveau(array $etudiants)
    {
        $sommeDesNiveau = 0;
        foreach ($etudiants as $etudiant) {
            $sommeDesNiveau += $etudiant["niveau"];
        }

        return $sommeDesNiveau;
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

        return $lettres;
    }

    function creationDeGroupeMembre(array $newGroupe)
    {
        DB::beginTransaction();
        try {
            foreach ($newGroupe as $groupe) {
                Groupe::create([
                    'nom'    => $groupe['nom'],
                    'statut' => 1,
                ]);

                $currentGroupe = Groupe::where('nom', $groupe['nom'])->first();
                unset($groupe['nom']);
                foreach ($groupe as $membre) {
                    GroupeEtudiant::create([
                        'etudiant_id' => $membre["id"],
                        'groupe_id' => $currentGroupe->id
                    ]);
                }
            }

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
        }
    }
}
