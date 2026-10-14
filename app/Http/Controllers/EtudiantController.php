<?php

namespace App\Http\Controllers;

use App\Models\Etudiant;
use Illuminate\Http\Request;
use Inertia\Inertia;

class EtudiantController extends Controller
{
    public function  index()
    {
        $etudiants = Etudiant::all();
        return Inertia::render('etudiant/List', compact('etudiants'));
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
