<?php

namespace App\Livewire;

use App\Models\Produit;
use Livewire\Component;
use App\Models\Atelier;

class DeleteProduct extends Component
{

    public $idproduit;
    public $idatelier;
    public $nomprod;
    public $nomatelier;


    public function mount($idproduit, $idatelier, $nomprod, $nomatelier)
    {
        $this->idatelier = $idatelier;
        $this->idproduit = $idproduit;
        $this->nomprod = $nomprod;
        $this->nomatelier = $nomatelier;
    }

    public function delete()
    {
        $produit = Produit::findOrFail($this->idproduit);
        $atelier = Atelier::findOrFail($this->idatelier);
        $atelier->contenir()->detach($this->idproduit);
        $this->dispatch('close-modal');
        $this->dispatch('refresh');
        $message = "Le produit $produit->nomprod a été effacé de l'atelier $atelier->nomatelier";
        $this->dispatch('entityAddedSuccess', [
            'type' => 'success',
            'message' => $message
        ]);
    }

    // #[On('openDeleteModal')]
    public function openModal()
    {
        $this->dispatch('open-delete-modal');
    }

    public function render()
    {
        return view('livewire.delete-product');
    }
}
