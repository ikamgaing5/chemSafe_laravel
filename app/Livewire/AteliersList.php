<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Atelier;
use App\Models\Usine;
use App\Helpers\IdEncryptor;

class AteliersList extends Component
{
    use WithPagination;

    public $usine_id;
    public $search = '';

    protected $paginationTheme = 'bootstrap'; // ou 'tailwind' selon ton CSS
    protected $listeners = ['refresh' => '$refresh'];

    public function updatingSearch()
    {
        $this->resetPage(); // remet à la première page lors d'une recherche
    }

    public function mount($usine_id)
    {
        $this->usine_id = $usine_id;
    }

    public function render()
    {
        $workshop = Atelier::withCount(['contenir', 'produitSansFds'])
            ->where('usine_id', $this->usine_id)
            ->where('active', 'true')
            ->where('nomatelier', 'like', '%' . $this->search . '%')
            ->orderBy('nomatelier', 'asc')
            ->paginate(5);

        $workshops = Atelier::withCount(['contenir', 'produitSansFds'])
            ->where('usine_id', $this->usine_id)
            ->where('active', 'true'); 
        $IdEncryptor = IdEncryptor::class;
        $usine = Usine::find($this->usine_id);

        return view('livewire.ateliers-list', compact('workshop', 'IdEncryptor', 'usine', 'workshops'));
    }
}