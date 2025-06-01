<?php

namespace App\Livewire;


use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Atelier;
use App\Models\Usine;
use App\Helpers\IdEncryptor;

class UsineList extends Component
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

    public function render()
    {
        $AllUsine = Usine::where('active', 'true') // récupère toutes les usines qui sont actives (celles qui ne sont pas supprimées)
        ->where('nomusine', 'like', '%'.$this->search . '%') // Permet la recherche
        ->with('ateliers') // relation avec atelier pour avoir le nombre d'atelier et permet de voir la liste des ateliers de l'usine
        ->orderBy('nomusine', 'asc') // l'ordre d'affichage des usine
        ->paginate(5); // nombre d'usine par page
        $IdEncryptor = IdEncryptor::class; // la classe qui permet de crypter les ID
        return view('livewire.usine-list', compact('AllUsine', 'IdEncryptor'));
    }
}
