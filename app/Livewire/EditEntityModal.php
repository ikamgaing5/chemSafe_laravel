<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Atelier;
use App\Models\Usine;
use Illuminate\Validation\Rule;
use Livewire\Attributes\On;

class EditEntityModal extends Component
{
    public $entityType;
    public $entityId;
    public $nom;
    public $usine_id;

    // Propriétés pour stocker les données originales
    public $originalNom;
    public $originalUsineId;

    public function mount($entityType = null, $entityId = null)
    {
        $this->entityType = $entityType;
        $this->entityId = $entityId;

        // Charger les données de l'entité seulement si un ID est fourni
        if ($this->entityId) {
            if ($this->entityType === 'atelier') {
                $atelier = Atelier::findOrFail($entityId);
                $this->nom = $atelier->nomatelier;
                $this->usine_id = $atelier->usine_id;
                $this->originalNom = $this->nom;
                $this->originalUsineId = $this->usine_id;
            } elseif ($this->entityType === 'usine') {
                $usine = Usine::findOrFail($entityId);
                $this->nom = $usine->nomusine;
                $this->originalNom = $this->nom;
            }
        }
    }

    #[On('openEditModal')]
    public function openModal($entityType, $entityId)
    {
        $this->mount($entityType, $entityId);
        $this->dispatch('open-edit-modal');
    }

    protected function rules()
    {
        $rules = [
            'nom' => [
                'required',
                'string',
                'max:255',
            ],
        ];

        if ($this->entityType === 'atelier') {
            $rules['nom'] = [
                Rule::unique('atelier', 'nomatelier')->where('usine_id', $this->usine_id)->ignore($this->entityId),
            ];
            $rules['usine_id'] = 'required|exists:usine,id';
        } elseif ($this->entityType === 'usine') {
            $rules['nom'][] = Rule::unique('usine', 'nomusine')->ignore($this->entityId);
        }

        return $rules;
    }

    protected function messages()
    {
        if ($this->entityType === 'atelier') {
            return [
                'nom.required' => 'Le nom de l\'atelier est obligatoire.',
                'nom.unique' => 'Ce nom est déjà utilisé par un autre atelier pour cette usine. Veuillez en choisir un autre.',
                'usine_id.required' => 'Veuillez sélectionner une usine.',
                'usine_id.exists' => 'L\'usine sélectionnée n\'est pas valide.',
            ];
        } elseif ($this->entityType === 'usine') {
            return [
                'nom.required' => 'Le nom de l\'usine est obligatoire.',
                'nom.unique' => 'Ce nom est déjà utilisé par une autre usine. Veuillez en choisir un autre.',
            ];
        }
        return [];
    }

    public function update()
    {
        $this->validate();

        if ($this->entityType === 'atelier') {
            $atelier = Atelier::findOrFail($this->entityId);

            // Vérifier si le nom ou l'usine_id a changé
            if ($this->nom === $atelier->nomatelier ) {
                $message = "Vous n'avez pas effectué de modification";
                $this->dispatch('entityAddedSuccess', [
                    'type' => 'danger',
                    'message' => $message ?? 'Entité modifiée avec succès!'
                ]);
                $this->dispatch('close-modal');
                // Vous pouvez choisir d'envoyer un message d'information si rien n'a changé
                // ou simplement ne rien faire.
                return;
            }

            $atelier->update([
                'nomatelier' => strtoupper($this->nom),
                'usine_id' => $this->usine_id,
            ]);
            $message = "L'atelier <strong>{$this->originalNom}</strong> a été modifié en <strong>{$this->nom}</strong> avec succès";

        } elseif ($this->entityType === 'usine') {
            $usine = Usine::findOrFail($this->entityId);

            // Vérifier si le nom a changé
            if ($this->nom === $this->originalNom) {
                $message = "Vous n'avez pas effectué de modification";
                $this->dispatch('entityAddedSuccess', [
                    'type' => 'danger',
                    'message' => $message ?? 'Entité modifiée avec succès!'
                ]);
                $this->dispatch('close-modal');
                return;
            }

            $usine->update([
                'nomusine' => strtoupper($this->nom),
            ]);
            $message = "L'<strong>{$this->originalNom}</strong> a été modifiée en <strong>{$this->nom}</strong> avec succès";
        }



        $this->dispatch('refresh'); // Nouvel événement

        // Fermer la modal
        $this->dispatch('close-modal');
        $this->dispatch('entityAddedSuccess', [
            'type' => 'success',
            'message' => $message ?? 'Entité modifiée avec succès!'
        ]);

    }

    public function render()
    {
        return view('livewire.edit-entity-modal');
    }
}