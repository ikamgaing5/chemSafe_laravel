<?php

namespace App\Livewire;

use App\Models\User;
use App\Models\Usine;
use Livewire\Component;
use Livewire\WithPagination;


class UserList extends Component
{


    

    public function render()
    {
        $user = User::with('usine')->get();
        $usine = Usine::with('users')->get();
        return view('livewire.user-list', compact('user', 'usine'));
    }
}
