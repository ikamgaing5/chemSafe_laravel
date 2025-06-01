<?php

namespace App\Livewire;

use App\Models\Atelier;
use App\Models\Usine;
use Livewire\Component;
use Livewire\Attributes\On;

class DeleteEntityModal extends Component
{

    public $entityType;
    public $entityId;
    public $nom;
    public $usine_id;


    public function mount($entityType = null, $entityId = null, $nom = null){
        $this->entityId = $entityId;
        $this->entityType = $entityType;
        $this->nom = $nom;
    }

    public function delete(){
        if ($this->entityId) {
            if ($this->entityType == "usine") {
                $usine = Usine::findOrFail($this->entityId);
                if ($usine->ateliers->count() > 0) {
                    //on ne supprime pas une usine qui contient des ateliers
                    $type = "danger";
                    $message = "Cette usine contient au moins un atelier et ne peut être supprimé";
                }else {
                    $type = "success";
                    $message = "L'usine $usine->nomusine a bien été supprimé";
                    $usine->update(['active' => 'false']);
                }
                
            }elseif ($this->entityType == 'atelier') {
                $atelier = Atelier::findOrFail($this->entityId);
                if ($atelier->contenir()->count() > 0) {
                    //on ne supprime pas un atelier qui contient des produits
                    $type = "danger";
                    $message = "Cet atelier contient au moins un produit et ne peut être supprimé";
                }else{
                    $type = "success";
                    $message = "L'atelier $atelier->nomatelier a bein été supprimé";
                    $atelier->update(['active' => 'false']);
                }
            }
            $this->dispatch('close-modal');
            $this->dispatch('entityDeleted');
            $this->dispatch('entityAddedSuccess', [
                'type' => $type,
                'message' => $message 
            ]);
        }
    } 

    #[On('openDeleteModal')]
    public function openModal($entityType, $entityId, $nom)
    {
        $this->mount($entityType, $entityId, $nom);
        $this->dispatch('open-delete-modal');
    }


    public function render()
    {
        return view('livewire.delete-entity-modal');
    }
}
