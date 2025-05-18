<?php

namespace App\Http\Controllers;

use App\Models\Usine;
use Illuminate\Http\Request;
use App\Models\Atelier;
use Illuminate\Support\Facades\Auth;
// use Illuminate\Support\Facades\Auth as FacadesAuth;

class AtelierController extends Controller
{
    public function all($idusine){
        $workshop = Atelier::where('idusine', $idusine);
        $AllUsine = Usine::all();
        $nomUsine = Usine::where($idusine);
        if (Auth::user()->role == 'superadmin') {
            $nbreAtelier = Atelier::count();
        }else {
            $nbreAtelier = Atelier::where('idusine', $idusine)->count();
        }

        
        return view('workshop.all',compact('workshop','nbreAtelier','AllUsine'));
    }
}
