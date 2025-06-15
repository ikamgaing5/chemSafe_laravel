<?php

namespace App\Livewire;

use App\Models\Atelier;
use App\Models\historique;
use App\Models\Produit;
use App\Models\Usine;
use Livewire\Component;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Auth;

class DeleteEntityModal extends Component
{

    public $entityType;
    public $entityId;
    public $nom;
    public $entitySecond;
    public $usine_id;


    public function mount($entityType = null, $entityId = null, $nom = null, $entitySecond = null){
        $this->entityId = $entityId;
        $this->entityType = $entityType;
        $this->entitySecond = $entitySecond;
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
                    historique::create([
                        'usine_id' => $usine->id,
                        'created_by' => Auth::user()->id,
                        'type' => 0,  // 1 pour la création et 0 pour la suppression
                        'action' => "Suppression de l'$usine->nomusine",
                        'created_at' => now(),
                    ]);
                }
                
            }elseif ($this->entityType == 'atelier') {
                $atelier = Atelier::findOrFail($this->entityId);
                if ($atelier->contenir()->count() > 0) {
                    //on ne supprime pas un atelier qui contient des produits
                    $type = "danger";
                    $message = "Cet atelier contient au moins un produit et ne peut être supprimé";
                }else{
                    $type = "success";
                    $message = "L'atelier $atelier->nomatelier a bien été supprimé";
                    $atelier->update(['active' => 'false']);
                    historique::create([
                        'atelier_id' => $atelier->id,
                        'created_by' => Auth::user()->id,
                        'type' => 0,  // 1 pour la création et 0 pour la suppression
                        'action' => "Suppression de l'atelier $atelier->nomatelier",
                        'created_at' => now(),
                    ]);

                }
            }elseif($this->entityType == 'produit'){
                $produit = Produit::findOrFail($this->entityId);
                $atelier = Atelier::findOrFail($this->entitySecond);
                $atelier->contenir()->detach($this->entityId);
                $message = "Le produit $produit->nomprod a bien été supprimé de l'atelier $atelier->nomatelier";
                $type = "success";

            }
            $this->dispatch('close-modal');
            $this->dispatch('refresh');
            $this->dispatch('entityAddedSuccess', [
                'type' => $type,
                'message' => $message 
            ]);
        }
    } 

    #[On('openDeleteModal')]
    public function openModal($entityType, $entityId, $nom, $entitySecond)
    {
        $this->mount($entityType, $entityId, $nom, $entitySecond);
        $this->dispatch('open-delete-modal');
    }


    public function render()
    {
        return view('livewire.delete-entity-modal');
    }
}
