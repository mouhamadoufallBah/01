<?php

namespace App\Http\Controllers;

use App\Models\Etudiant;
use App\Models\Groupe;
use Illuminate\Http\Request;
use Inertia\Inertia;

class EtudiantController extends Controller
{
    public function  index()
    {
        $etudiants = Etudiant::all();
        $groupeEtudiant = $groupeEtudiant = Groupe::with('etudiants')
            ->where('statut', 1)
            ->get();
        
        foreach ($groupeEtudiant as $groupe) {
            $groupe["sommeNiveau"] = 0;
            foreach ($groupe['etudiants'] as $etudiant) {
                $groupe["sommeNiveau"] += $etudiant['niveau'];
            }
        }

        // dd($groupeEtudiant);
        return Inertia::render('etudiant/List', compact('etudiants', 'groupeEtudiant'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nomComplet' => 'required|string|max:255',
            'sexe'       => 'required|string|in:Masculin,6',
            'niveau'     => 'required|string|max:10',
        ]);

        Etudiant::create($validated);

        return redirect()->route('etudiant.list')->with('message', 'Étudiant créé avec succès !');
    }
}
