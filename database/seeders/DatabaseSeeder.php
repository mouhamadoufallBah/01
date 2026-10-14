<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        $now = Carbon::now();

        // ---------------------------------------------------------
        // 1. GROUPES  (avec niveau = 1, 2 ou 3)
        // ---------------------------------------------------------
        $groupes = [
            ['nom' => 'Groupe A', 'statut' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['nom' => 'Groupe B', 'statut' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['nom' => 'Groupe C', 'statut' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['nom' => 'Groupe D', 'statut' => 0, 'created_at' => $now, 'updated_at' => $now],
            ['nom' => 'Groupe E', 'statut' => 1, 'created_at' => $now, 'updated_at' => $now],
        ];

        DB::table('groupes')->insert($groupes);

        // ---------------------------------------------------------
        // 2. ETUDIANTS
        // ---------------------------------------------------------
        $etudiants = [
            ['nomComplet' => 'Jean Dupont',    'sexe' => 'Masculin', 'niveau' => 1,'created_at' => $now, 'updated_at' => $now],
            ['nomComplet' => 'Marie Curie',    'sexe' => 'Féminin', 'niveau' => 3,'created_at' => $now, 'updated_at' => $now],
            ['nomComplet' => 'Amadou Diallo',  'sexe' => 'Masculin', 'niveau' => 1,'created_at' => $now, 'updated_at' => $now],
            ['nomComplet' => 'Fatou Ndiaye',   'sexe' => 'Féminin', 'niveau' => 1,'created_at' => $now, 'updated_at' => $now],
            ['nomComplet' => 'Moussa Traoré',  'sexe' => 'Masculin', 'niveau' => 2,'created_at' => $now, 'updated_at' => $now],
            ['nomComplet' => 'Awa Sow',        'sexe' => 'Féminin', 'niveau' => 1,'created_at' => $now, 'updated_at' => $now],
            ['nomComplet' => 'Ibrahim Camara', 'sexe' => 'Masculin', 'niveau' => 1,'created_at' => $now, 'updated_at' => $now],
            ['nomComplet' => 'Aïcha Ba',       'sexe' => 'Féminin', 'niveau' => 2,'created_at' => $now, 'updated_at' => $now],
            ['nomComplet' => 'Cheikh Fall',    'sexe' => 'Masculin', 'niveau' => 3,'created_at' => $now, 'updated_at' => $now],
            ['nomComplet' => 'Mariama Sylla',  'sexe' => 'Féminin', 'niveau' => 1,'created_at' => $now, 'updated_at' => $now],
            ['nomComplet' => 'Ousmane Kane',   'sexe' => 'Masculin', 'niveau' => 3,'created_at' => $now, 'updated_at' => $now],
            ['nomComplet' => 'Bineta Diop',    'sexe' => 'Féminin', 'niveau' => 1,'created_at' => $now, 'updated_at' => $now],
        ];

        DB::table('etudiants')->insert($etudiants);

        // ---------------------------------------------------------
        // 3. PIVOT groupe_etudiants
        // ---------------------------------------------------------
        $groupeIds   = DB::table('groupes')->pluck('id')->toArray();
        $etudiantIds = DB::table('etudiants')->pluck('id')->toArray();

        $pivot = [];

        // Groupe 1 (niveau 1) -> étudiants 1 à 3
        foreach (array_slice($etudiantIds, 0, 3) as $eid) {
            $pivot[] = [
                'groupe_id'   => $groupeIds[0],
                'etudiant_id' => $eid,
                'created_at'  => $now,
                'updated_at'  => $now,
            ];
        }

        // Groupe 2 (niveau 1) -> étudiants 4 à 6
        foreach (array_slice($etudiantIds, 3, 3) as $eid) {
            $pivot[] = [
                'groupe_id'   => $groupeIds[1],
                'etudiant_id' => $eid,
                'created_at'  => $now,
                'updated_at'  => $now,
            ];
        }

        // Groupe 3 (niveau 2) -> étudiants 7 à 9
        foreach (array_slice($etudiantIds, 6, 3) as $eid) {
            $pivot[] = [
                'groupe_id'   => $groupeIds[2],
                'etudiant_id' => $eid,
                'created_at'  => $now,
                'updated_at'  => $now,
            ];
        }

        // Groupe 4 (niveau 2) -> étudiants 10 à 11
        foreach (array_slice($etudiantIds, 9, 2) as $eid) {
            $pivot[] = [
                'groupe_id'   => $groupeIds[3],
                'etudiant_id' => $eid,
                'created_at'  => $now,
                'updated_at'  => $now,
            ];
        }

        // Groupe 5 (niveau 3) -> étudiant 12
        $pivot[] = [
            'groupe_id'   => $groupeIds[4],
            'etudiant_id' => $etudiantIds[11],
            'created_at'  => $now,
            'updated_at'  => $now,
        ];

        DB::table('groupe_etudiants')->insert($pivot);
    }
}
