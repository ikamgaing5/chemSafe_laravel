<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UsineController extends Controller
{
    public function all(){
        
        return view('factory.all', compact(''));
    }
}
