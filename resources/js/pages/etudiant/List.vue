<script setup>
import { useForm } from "@inertiajs/vue3";
import { ref } from "vue";

const props = defineProps({
  etudiants: Array,
  groupeEtudiant: Array
});

console.log(props.groupeEtudiant, 'groupeEtudiant')

const isModalOpen = ref(false);
const isModalGroupeOpen = ref(false);

function openModalGroupe() {
  isModalGroupeOpen.value = !isModalGroupeOpen.value;
}

function openModal() {
  isModalOpen.value = !isModalOpen.value;
  form.reset();
}

const form = useForm({
  nomComplet: "",
  sexe: "",
  niveau: "",
});

const formGroup = useForm({
  nombrePersonneParGroupe: "",
  etudiants: props.etudiants,
});

function saveEtudiant() {
  form.post("/etudiant", {
    onSuccess: () => openModal(),
  });
}

function createGroupe() {
  formGroup.post("/creation-groupe", {
    onSuccess: () => openModalGroupe(),
  });
}
</script>

<template>
  <section class="min-h-screen bg-background text-foreground p-6">
    <div class="max-w-5xl mx-auto space-y-6">
      <!-- En-tête -->
      <div class="flex items-center justify-between">
        <div>
          <h1 class="text-2xl font-bold tracking-tight">
            Gestion des Étudiants
          </h1>
          <p class="text-sm text-muted-foreground">
            Liste et ajout des étudiants
          </p>
        </div>
        <button
          @click="openModal"
          class="inline-flex items-center gap-2 rounded-md bg-primary px-4 py-2 text-sm font-medium text-primary-foreground shadow-sm transition-colors hover:bg-primary/90 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2"
        >
          <svg
            xmlns="http://www.w3.org/2000/svg"
            class="h-4 w-4"
            fill="none"
            viewBox="0 0 24 24"
            stroke="currentColor"
            stroke-width="2"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              d="M12 4v16m8-8H4"
            />
          </svg>
          Ajouter un étudiant
        </button>
      </div>

      <!-- Tableau -->
      <div class="rounded-lg border border-border bg-card shadow-sm">
        <div class="overflow-x-auto">
          <table class="w-full text-sm">
            <thead>
              <tr class="border-b border-border bg-muted/50">
                <th
                  class="px-4 py-3 text-left font-medium text-muted-foreground"
                >
                  #
                </th>
                <th
                  class="px-4 py-3 text-left font-medium text-muted-foreground"
                >
                  Nom complet
                </th>
                <th
                  class="px-4 py-3 text-left font-medium text-muted-foreground"
                >
                  Sexe
                </th>
                <th
                  class="px-4 py-3 text-left font-medium text-muted-foreground"
                >
                  Niveau
                </th>
                <!-- <th
                  class="px-4 py-3 text-right font-medium text-muted-foreground"
                >
                  Actions
                </th> -->
              </tr>
            </thead>
            <tbody>
              <!-- Ligne 1 -->
              <tr
                v-for="etudiant in props.etudiants"
                :key="etudiant.id"
                class="border-b border-border last:border-0 hover:bg-accent/50 transition-colors"
              >
                <td class="px-4 py-3 text-muted-foreground">
                  {{ etudiant.id }}
                </td>
                <td class="px-4 py-3 font-medium">{{ etudiant.nomComplet }}</td>
                <td class="px-4 py-3">
                  <span
                    class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium"
                    :class="
                      etudiant.sexe === 'Masculin'
                        ? 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300'
                        : 'bg-pink-100 text-pink-800 dark:bg-pink-900/30 dark:text-pink-300'
                    "
                  >
                    {{ etudiant.sexe }}
                  </span>
                </td>
                <td class="px-4 py-3">
                  <span
                    class="inline-flex items-center rounded-md border border-border bg-secondary px-2 py-0.5 text-xs font-medium text-secondary-foreground"
                  >
                    {{ etudiant.niveau }}
                  </span>
                </td>
                <!-- <td class="px-4 py-3 text-right">
                  <button
                    class="inline-flex items-center gap-1 rounded-md px-2 py-1 text-xs font-medium text-destructive hover:bg-destructive/10 transition-colors"
                  >
                    <svg
                      xmlns="http://www.w3.org/2000/svg"
                      class="h-3.5 w-3.5"
                      fill="none"
                      viewBox="0 0 24 24"
                      stroke="currentColor"
                      stroke-width="2"
                    >
                      <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"
                      />
                    </svg>
                    Supprimer
                  </button>
                </td> -->
              </tr>
            </tbody>
          </table>
        </div>
      </div>

      <button
        @click="openModalGroupe"
        class="inline-flex items-center gap-2 rounded-md bg-primary px-4 py-2 text-sm font-medium text-primary-foreground shadow-sm transition-colors hover:bg-primary/90 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2"
      >
        <svg
          xmlns="http://www.w3.org/2000/svg"
          class="h-4 w-4"
          fill="none"
          viewBox="0 0 24 24"
          stroke="currentColor"
          stroke-width="2"
        >
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            d="M4 4h1.44a2 2 0 011.664.89l3.792 5.51A2 2 0 0012.56 11.3H20M20 11.3l-3-3m3 3l-3 3M4 20h1.44a2 2 0 001.664-.89l3.792-5.51A2 2 0 0112.56 12.7H20M20 12.7l-3-3m3 3l-3 3"
          />
        </svg>

        Creation de groupe
      </button>

      <!-- Cartes des groupes -->
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
        <!-- Groupe 1 -->
        <div v-for="groupe in props.groupeEtudiant"  :key="groupe.id" class="rounded-lg border border-border bg-card p-4 shadow-sm">
          <div class="mb-3 flex items-center justify-between">
            <h3 class="text-sm font-semibold">{{ groupe.nom }}</h3>
            <div class="flex items-center gap-2">
              <span
                class="inline-flex items-center rounded-full bg-primary/10 px-2.5 py-0.5 text-xs font-medium text-primary"
              >
                {{ groupe.etudiants.length }} membres
              </span>
              <span
                class="inline-flex items-center rounded-full bg-secondary px-2.5 py-0.5 text-xs font-medium text-secondary-foreground"
              >
                Somme: {{ groupe.sommeNiveau }}
              </span>
            </div>
          </div>
          <ul class="space-y-2">
            <li v-for="etudiant in groupe.etudiants" :key="etudiant.id" class="flex items-center justify-between text-sm">
              <span class="flex items-center gap-2">
                <span :class="etudiant.sexe === 'Masculin'? 'h-2 w-2 rounded-full bg-blue-500' : 'h-2 w-2 rounded-full bg-pink-500'"></span>
                {{ etudiant.nomComplet }}
              </span>
              <span
                class="inline-flex items-center rounded-md border border-border bg-secondary px-2 py-0.5 text-xs font-medium text-secondary-foreground"
              >
                Niveau {{ etudiant.niveau }}
              </span>
            </li>
          </ul>
        </div>
      </div>

      <!-- Modal Formulaire -->
      <div
        v-show="isModalOpen"
        class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4"
      >
        <div
          class="w-full max-w-md rounded-lg border border-border bg-card p-6 shadow-lg"
        >
          <div class="mb-4 flex items-center justify-between">
            <h2 class="text-lg font-semibold">Ajouter un étudiant</h2>
            <button
              @click="openModal"
              class="rounded-md p-1 text-muted-foreground hover:bg-accent hover:text-accent-foreground transition-colors"
            >
              <svg
                xmlns="http://www.w3.org/2000/svg"
                class="h-5 w-5"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
                stroke-width="2"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  d="M6 18L18 6M6 6l12 12"
                />
              </svg>
            </button>
          </div>

          <form @submit.prevent="saveEtudiant" class="space-y-4">
            <!-- Nom complet -->
            <div class="space-y-2">
              <label for="nomComplet" class="text-sm font-medium"
                >Nom complet</label
              >
              <input
                id="nomComplet"
                type="text"
                v-model="form.nomComplet"
                placeholder="Ex: Jean Dupont"
                class="flex h-9 w-full rounded-md border border-input bg-transparent px-3 py-1 text-sm shadow-sm transition-colors placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring"
              />
            </div>

            <!-- Sexe -->
            <div class="space-y-2">
              <label class="text-sm font-medium">Sexe</label>
              <div class="flex gap-4">
                <label class="flex items-center gap-2 text-sm cursor-pointer">
                  <input
                    v-model="form.sexe"
                    type="radio"
                    name="sexe"
                    value="Masculin"
                    class="h-4 w-4 text-primary focus:ring-ring"
                  />
                  Masculin
                </label>
                <label class="flex items-center gap-2 text-sm cursor-pointer">
                  <input
                    v-model="form.sexe"
                    type="radio"
                    name="sexe"
                    value="Féminin"
                    class="h-4 w-4 text-primary focus:ring-ring"
                  />
                  Féminin
                </label>
              </div>
            </div>

            <!-- Niveau -->
            <div class="space-y-2">
              <label for="niveau" class="text-sm font-medium">Niveau</label>
              <select
                v-model="form.niveau"
                id="niveau"
                class="flex h-9 w-full rounded-md border border-input bg-transparent px-3 py-1 text-sm shadow-sm transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring"
              >
                <option value="" disabled selected>
                  Sélectionner un niveau
                </option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
              </select>
            </div>

            <!-- Actions -->
            <div class="flex justify-end gap-3 pt-2">
              <button
                @click="openModal"
                type="button"
                class="inline-flex items-center rounded-md border border-border bg-background px-4 py-2 text-sm font-medium shadow-sm transition-colors hover:bg-accent hover:text-accent-foreground"
              >
                Annuler
              </button>
              <button
                :disabled="form.processing"
                type="submit"
                class="inline-flex items-center rounded-md bg-primary px-4 py-2 text-sm font-medium text-primary-foreground shadow-sm transition-colors hover:bg-primary/90"
              >
                Enregistrer
              </button>
            </div>
          </form>
        </div>
      </div>

      <!-- modal creation de groupe -->
      <div
        v-show="isModalGroupeOpen"
        class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4"
      >
        <div
          class="w-full max-w-md rounded-lg border border-border bg-card p-6 shadow-lg"
        >
          <div class="mb-4 flex items-center justify-between">
            <h2 class="text-lg font-semibold">Creer un groupe</h2>
            <button
              @click="openModalGroupe"
              class="rounded-md p-1 text-muted-foreground hover:bg-accent hover:text-accent-foreground transition-colors"
            >
              <svg
                xmlns="http://www.w3.org/2000/svg"
                class="h-5 w-5"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
                stroke-width="2"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  d="M6 18L18 6M6 6l12 12"
                />
              </svg>
            </button>
          </div>

          <form @submit.prevent="createGroupe" class="space-y-4">
            <div class="space-y-2">
              <label for="nomComplet" class="text-sm font-medium"
                >Nombre apprenant par groupe</label
              >
              <input
                id="nomComplet"
                type="number"
                v-model="formGroup.nombrePersonneParGroupe"
                placeholder="Ex: 3"
                class="flex h-9 w-full rounded-md border border-input bg-transparent px-3 py-1 text-sm shadow-sm transition-colors placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring"
              />
            </div>

            <!-- Actions -->
            <div class="flex justify-end gap-3 pt-2">
              <button
                @click="openModalGroupe"
                type="button"
                class="inline-flex items-center rounded-md border border-border bg-background px-4 py-2 text-sm font-medium shadow-sm transition-colors hover:bg-accent hover:text-accent-foreground"
              >
                Annuler
              </button>
              <button
                type="submit"
                class="inline-flex items-center rounded-md bg-primary px-4 py-2 text-sm font-medium text-primary-foreground shadow-sm transition-colors hover:bg-primary/90"
              >
                Enregistrer
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>
</template>