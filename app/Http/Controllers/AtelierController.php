<?php

namespace App\Http\Controllers;

use App\Models\Usine;
use Illuminate\Http\Request;
use App\Models\Atelier;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
// use Illuminate\Support\Facades\Auth as FacadesAuth;

class AtelierController extends Controller
{
    public function all($idusine)
    {
        $idusine = Crypt::decrypt($idusine);
        // $usine = Usine::where('id', $idusine);
        $usine = Usine::find($idusine);
        $workshop = Atelier::withCount([
            'contenir',
            'produitsSansFds'
        ])->where('usine_id', $idusine)->get();
        $AllUsine = Usine::where('active', 1)->orderBy('nomusine', 'asc')->get();

        if (Auth::user()->role == 'superadmin') {
            $nbreAtelier = Atelier::where('active', 'true')->count();
        } else {
            $nbreAtelier = Atelier::where('usine_id', $idusine)->where('active', 'true')->count();
        }

        return view('workshop.all', compact('workshop', 'nbreAtelier', 'AllUsine', 'usine','idusine'));
    }

    public function alls()
    {
        $AllUsine = Usine::where('active', true)->orderBy('nomusine', 'asc')->get();

        return view('workshop.alls', compact('AllUsine'));
    }
}