<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\AlertHelper;
use App\Models\historique_acces;
use App\Models\User;

class HistoryController extends Controller
{
    public function all(){
        $AlertHelper = new AlertHelper();
        $all = User::with('historique_acces')->orderBy('id')->get();
        $message = 'Historique de Connexion.';
        return view('history.user', compact('all', 'message', 'AlertHelper'));
    }
}
