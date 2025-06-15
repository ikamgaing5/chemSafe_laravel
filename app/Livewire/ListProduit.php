<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Produit;
use App\Models\Atelier;
use App\Models\Danger;
use App\Helpers\IdEncryptor;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class ListProduit extends Component
{
    use WithPagination;

    public $search = '';
    public $atelier_id;
    public $idatelier; // Stocker l'ID décodé

    protected $paginationTheme = 'bootstrap';
    protected $listeners = ['refresh' => '$refresh'];

    public function mount($atelier_id = null)
    {
        $this->atelier_id = $atelier_id;
    }

    // Réinitialiser la pagination quand la recherche change
    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = Produit::whereHas('atelier', function ($query) {
            $query->where('id', $this->atelier_id);
        });

        // Appliquer la recherche seulement si elle n'est pas vide
        if (!empty($this->search)) {
            $query->where(function ($q) {
                $q->where('nomprod', 'like', '%' . $this->search . '%')
                    ->orWhere('type_emballage', 'like', '%' . $this->search . '%')
                    ->orWhere('nature', 'like', '%' . $this->search . '%')
                    ->orWhere('fabricant', 'like', '%' . $this->search . '%');
            });
        }

        $produits = $query->orderBy('nomprod', 'asc')->paginate(40);

        $dangers = Danger::whereHas('produit', function ($query) {
            $query->whereHas('atelier', function ($q) {
                $q->where('id', $this->atelier_id);
            });
        })->get();

        $atelier = Atelier::with('usine')->findOrFail($this->atelier_id);

        $produitsSansAtelier = Produit::whereDoesntHave('atelier', function ($query) {
            $query->where('atelier_id', $this->atelier_id);
        })->get();

        return view('livewire.list-produit', compact('produits', 'atelier', 'produitsSansAtelier', 'dangers') + ['IdEncryptor' => IdEncryptor::class]);
    }
}