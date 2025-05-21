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
use Illuminate\Http\RedirectResponse;
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

    public function files($file, $type)
    {
        // Définir les paramètres selon le type
        if ($type === "fds") {
            $maxSize = 10240 * 1024; // 10 Mo
            $folder = "fds";
            $allowedExtensions = ['pdf'];
            $typeLabel = 'FDS';
        } else {
            $maxSize = 10240 * 512; // 5 Mo
            $folder = "photo";
            $allowedExtensions = ['png', 'jpg', 'jpeg'];
            $typeLabel = 'photo';
        }

        // Vérification de la taille
        if ($file->getSize() > $maxSize) {
            return redirect()->back()->with('error', "Le fichier dépasse la taille maximale autorisée pour les $typeLabel.");
        }

        $fileName = $file->getClientOriginalName();
        $storagePath = "uploads/$folder/$fileName";

        // Vérification de l'existence du fichier
        if (Storage::disk('public')->exists($storagePath)) {
            return redirect()->back()->with('error', "Un fichier du même nom existe déjà dans $typeLabel.");
        }

        // Vérification de l’extension
        $extension = strtolower($file->getClientOriginalExtension());
        if (!in_array($extension, $allowedExtensions)) {
            return redirect()->back()->with('error', "Le fichier doit être de type : " . implode(', ', $allowedExtensions) . ".");
        }

        // Tout est ok → retourner le chemin proposé (ou stocker ici si tu veux)
        return $storagePath;
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

        $temoinFDS = false;

        // Upload photo
        if ($request->hasFile('photo')) {            
            $path = $this->files($request->file('photo'), 'photo');
            if ($path instanceof RedirectResponse) {
                return $path; // Redirige avec message d'erreur
            }
            // Sinon, continue avec le stockage
            $stored = $request->file('photo')->storeAs("uploads/photo", basename($path), 'public');
            $produit->photo = $stored;
        }
        if ($request->hasFile('fds')) {
            $path = $this->files($request->file('fds'), 'fds');
            if ($path instanceof RedirectResponse) {
                return $path; // Redirige avec message d'erreur
            }
            // Sinon, continue avec le stockage
            $stored = $request->file('fds')->storeAs("uploads/fds", basename($path), 'public');
            $produit->fds = $stored;
            $temoinFDS = true;
        }



        

        $produit->save();
        $produit->danger()->sync($validated['danger']);
        $produit->atelier()->sync($validated['atelier']);

        if ($temoinFDS) {
            return redirect()->route('infofds.add', $produit->id);
        } else {
            return redirect()->back()->with('success', 'Produit ajouté avec succès !');
        }

    }

    public function addFDS(Request $request, $id)
    {
        // Vérifie si un fichier est envoyé
        if (!$request->hasFile('fds')) {
            return redirect()->back()->with('error', 'Aucun fichier n’a été envoyé.');
        }

        $path = $this->files($request->file('fds'), 'fds');
        if ($path instanceof RedirectResponse) {
            return $path; // Redirige avec message d'erreur
        }

        // Sinon, continue avec le stockage
        $stored = $request->file('fds')->storeAs("uploads/fds", basename($path), 'public');
        Produit::find($id)->update(['fds' => $stored]);

        return redirect()->route('infofds.add', $id);
    }

    public function one($idatelier, $idproduit)
    {
        $atelier = Atelier::with('usine')->find($idatelier);
        $prod = Produit::with('danger', 'infofds')->find($idproduit);
        return view('product.one', compact('prod', 'atelier'));
    }

}
