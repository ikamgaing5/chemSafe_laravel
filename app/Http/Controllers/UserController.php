<?php

namespace App\Http\Controllers;

use App\Models\Usine;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function dashboard(){
        return view('user.dashboard');
    }

    public function home(){
        return view('index',['title' => 'ChemSafe']);
    }

    public function add(){
        $usinesSansUtilisateur = Usine::doesntHave('users')->where('active', true)->get();
        return view('user.add', compact('usinesSansUtilisateur'));
    }


}
