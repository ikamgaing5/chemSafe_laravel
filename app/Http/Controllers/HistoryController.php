<?php

namespace App\Http\Controllers;

use App\Models\historique;
use Illuminate\Http\Request;
use App\Helpers\AlertHelper;
use App\Helpers\IdEncryptor;
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

    public function historyWorkshop(){
        $AlertHelper = AlertHelper::class;
        $allWorkshops = historique::whereNotNull('atelier_id')->with('userr', 'atelier')->get();
        $message = 'Historique relative aux Ateliers.';
        // dd($allWorkshops);
        return view('history.workshop', compact('message', 'allWorkshops', 'AlertHelper'));
    }

    public function TrashWorkshop(){
        $AlertHelper = AlertHelper::class;
        $IdEncryptor = IdEncryptor::class;
        $allWorkshops = historique::whereNotNull('atelier_id')->where('type',0 )->with('userr', 'atelier')->get();
        $message = 'Corbeille des Ateliers.';

        return view('trash.workshop', compact('message', 'allWorkshops', 'AlertHelper', 'IdEncryptor'));
    }
}
