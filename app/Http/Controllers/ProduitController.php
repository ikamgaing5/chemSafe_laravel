<?php

namespace App\Http\Controllers;

use App\Models\Usine;
use App\Models\Danger;
use App\Models\Atelier;
use App\Models\Produit;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProduitController extends Controller
{
    public function allByWorkshop($idatelier)
    {
        // $id = $idatelier;
        $produits = Produit::whereHas('atelier', function ($query) use ($idatelier) {
            $query->where('id', $idatelier);
        })->get();

        $dangers = Danger::whereHas('produit', function ($query) use ($idatelier) {
            $query->whereHas('atelier', function ($q) use ($idatelier) {
                $q->where('id', $idatelier);
            });
        })->get();

        $atelier = Atelier::with('usine')->find($idatelier);

        return view('product.all', compact('produits', 'dangers', 'atelier'));
    }

    public function add()
    {
        $danger = Danger::all();
        if (Auth::user()->role == "superadmin") {
            $ateliers = Atelier::with('usine')->where('active', 'true')->orderBy('usine_id')->get();
        } else {
            $ateliers = Atelier::with('usine')->where('active', 'true')->where('usine_id', Auth::user()->usine_id)->orderBy('nomatelier')->get();
        }
        return view('product.add', compact('danger', 'ateliers'));
    }


    public function addPost(Request $request)
    {
        $validated = $request->validate([
            'nomprod' => ['required', 'string', 'max:255', Rule::unique('produit', 'nomprod')],
            'type_emballage' => ['required', 'string', 'max:255'],
            'poids' => ['required', 'string', 'max:255'],
            'nature' => ['required', 'string', 'max:255'],
            'utilisation' => ['required', 'string', 'max:255'],
            'fabricant' => ['required', 'string', 'max:255'],
            'photo' => ['required', 'file', 'image', 'mimes:jpg,jpeg,png,gif', 'max:8192'],
            'fds' => ['nullable', 'file', 'mimes:pdf', 'max:10240'],
            'risque' => ['required', 'string', 'max:255'],
            'danger' => 'required|array',
            'atelier' => 'required|array',
        ]);

        $produit = Produit::create([
            'nomprod' => strtoupper($request->input('nomprod')),
            'type_emballage' => strtoupper($request->input('type_emballage')),
            'poids' => strtoupper($request->input('poids')),
            'nature' => strtoupper($request->input('nature')),
            'utilisation' => strtoupper($request->input('utilisation')),
            'fabricant' => strtoupper($request->input('fabricant')),
            'photo' => '',
            'fds' => '',
            'risque' => strtoupper($request->input('risque')),
        ]);

        // Upload photo
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('uploads/photo', 'public');
            $produit->photo = $photoPath;
        }

        // Upload FDS (si fourni)
        if ($request->hasFile('fds')) {
            $fdsPath = $request->file('fds')->store('uploads/fds', 'public');
            $produit->fds = $fdsPath;
        }

        $produit->save();
        $produit->danger()->sync($validated['danger']);
        $produit->atelier()->sync($validated['atelier']);

        return redirect()->back()->with('success', 'Produit ajouté avec succès !');
    }

    public function one($idatelier, $idproduit)
    {
        $atelier = Atelier::with('usine')->find($idatelier);
        // $prod = Produit::find($idproduit);
        $danger = Danger::with('produit')->where('id', [3, 2])->get();
        // $danger = Danger::all();
        $prod = Produit::with(['danger'])->where('id', $idproduit)->get();
        $danger = DB::table('possede')->where('produit_id', $idproduit)->get();
        $prod = Produit::with('danger')->find($idproduit);

        // $idusine = Auth::user()->usine_id;
        return view('product.one', compact('prod', 'atelier'));
    }

}
