<?php

namespace App\Livewire;

use App\Models\historique;
use Livewire\Component;
use App\Models\Atelier;
use App\Models\Usine;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class AddEntityModal extends Component
{
    public $entityType;
    public $nom;
    public $usine_id;

    public function mount($entityType, $usineId = null)
    {
        $this->entityType = $entityType;
        $this->usine_id = $usineId;
    }

    public $usine; // Add this property


    protected function rules()
    {
        $rules = [
            'nom' => ['required', 'string', 'max:255'],
        ];

        if ($this->entityType === 'atelier') {
            $rules['nom'][] = Rule::unique('atelier', 'nomatelier')->where(function ($query) {
                return $query->where('usine_id', $this->usine_id);
            });
            $rules['usine_id'] = 'required|exists:usine,id';
        } elseif ($this->entityType === 'usine') {
            $rules['nom'][] = Rule::unique('usine', 'nomusine');
        }

        return $rules;
    }

    protected function messages()
    {
        return [
            'nom.required' => 'Le nom est obligatoire.',
            'nom.unique' => 'Ce nom est déjà utilisé. Veuillez en choisir un autre.',
            'usine_id.required' => 'Veuillez sélectionner une usine.',
            'usine_id.exists' => 'L’usine sélectionnée n’est pas valide.',
        ];
    }


    public function save()
    {
        $this->validate();

        if ($this->entityType === 'atelier') {
            $atelier = Atelier::create([
                'nomatelier' => strtoupper($this->nom),
                'usine_id' => $this->usine_id,

            ]);
            
            historique::create([
                'atelier_id' => $atelier->id,
                'created_by' => Auth::user()->id,
                'type' => 1,  // 1 pour la création et 0 pour la suppression
                'action' => "Création de l'atelier $atelier->nomatelier",
                'created_at' => now(),
            ]);
            $nom = strtoupper($this->nom);
            $entite = "Atelier <strong>$nom</strong> a bien été ajouté";
        } elseif ($this->entityType === 'usine') {
            $usine = Usine::create([
                'nomusine' => strtoupper($this->nom),
            ]);
            historique::create([
                'usine_id' => $usine->id,
                'created_by' => Auth::user()->id,
                'type' => 1,  // 1 pour la création et 0 pour la suppression
                'action' => "Création de l'$usine->nomusine",
                'created_at' => now(),
            ]);
            $nom = strtoupper($this->nom);
            $entite = "Usine <strong>$nom</strong> a bien été ajoutée";
        }

        $this->reset(['nom', 'usine_id']);

        // Envoyer un seul événement entityAdded pour rafraîchir la liste
        $this->dispatch('refresh');

        // Fermer la modal
        $this->dispatch('close-modal');

        // Envoyer l'événement pour afficher l'alerte avec les données nécessaires
        $this->dispatch('entityAddedSuccess', [
            'type' => 'success',
            'message' => $entite
        ]);


    }



    public function render()
    {
        return view('livewire.add-entity-modal');
    }
}