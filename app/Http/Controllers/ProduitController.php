<?php

namespace App\Http\Controllers;

use App\Models\Usine;
use App\Models\Danger;
use App\Models\Atelier;
use App\Models\Produit;
use App\Helpers\AlertHelper;
use App\Helpers\IdEncryptor;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

class ProduitController extends Controller
{
    public function allByWorkshop($idatelier)
    {
        $idatelier = IdEncryptor::decode($idatelier);
        $produits = Produit::whereHas('atelier', function ($query) use ($idatelier) {
            $query->where('id', $idatelier);
        })->get();

        $dangers = Danger::whereHas('produit', function ($query) use ($idatelier) {
            $query->whereHas('atelier', function ($q) use ($idatelier) {
                $q->where('id', $idatelier);
            });
        })->get();

        $atelier = Atelier::with('usine')->find($idatelier);

        $produitsSansAtelier = Produit::whereDoesntHave('atelier', function ($query) use ($idatelier) {
            $query->where('atelier_id', $idatelier);
        })->get();


        return view('product.all', compact('produits', 'dangers', 'atelier', 'produitsSansAtelier'));
    }

    public function addWorkshop(Request $request, $idatelier)
    {
        $atelier = Atelier::findOrFail($idatelier);

        $request->validate([
            'produit' => 'required|array',
            'produit.*' => 'exists:produit,id',
        ]);

        $produits = Produit::whereIn('id', $request->produit)->get();

        $atelier->contenir()->syncWithoutDetaching($request->produit);

        $nomsProduits = $produits->pluck('nomprod')->implode(', ');
        return redirect()->back()->with('addFromWorkshop', AlertHelper::message("Le(s) produit(s) $nomsProduits ont été ajouté(s) avec succès", 'success'));

    }

    public function deleteFromWorkshop(Request $request, $idproduit, $idatelier)
    {
        $nom = $request->input('nomprod');
        $atelier = Atelier::findOrFail($idatelier);

        $atelier->contenir()->detach($idproduit);

        return redirect()->back()->with('deletesuccess', AlertHelper::message("Le produit <strong>$nom</strong> a été supprimé de l'atelier <strong>$atelier->nomatelier</strong>", "success"));
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

    public function getDangerDatas()
    {
        if (Auth::user()->role == 'superadmin') {
            $result = $this->getDangerData();
        } else {
            $result = $this->getDangerDatass(Auth::user()->idusine);
        }
        echo $result;
    }

    public function getDangerDatass($idusine)
    {
        try {
            $results = DB::table('danger as d')
                ->leftJoin('possede as pos', 'd.id', '=', 'pos.danger_id')
                ->leftJoin('produit as p', 'pos.produit_id', '=', 'p.id')
                ->leftJoin('contenir as c', 'p.id', '=', 'c.produit_id')
                ->leftJoin('atelier as a', 'c.atelier_id', '=', 'a.id')
                ->where('a.usine_id', $idusine)
                ->select(
                    'd.id',
                    'd.nomdanger as nom_danger',
                    DB::raw('COUNT(DISTINCT p.idprod) as total_produits')
                )
                ->groupBy('d.id', 'd.nomdanger')
                ->orderByDesc('total_produits')
                ->get();

            return response()->json($results);

        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'message' => 'Erreur de base de données : ' . $e->getMessage()
            ], 500);
        }
    }

    public function getDangerData()
    {
        try {
            $results = DB::table('danger as d')
                ->leftJoin('possede as pos', 'd.id', '=', 'pos.danger_id')
                ->leftJoin('produit as p', 'pos.produit_id', '=', 'p.id')
                ->select('d.id', 'd.nomdanger as nom_danger', DB::raw('COUNT(p.id) as total_produits'))
                ->groupBy('d.id', 'd.nomdanger')
                ->orderByDesc('total_produits')
                ->get();

            return response()->json($results);

        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'message' => 'Erreur de base de données : ' . $e->getMessage(),
            ], 500);
        }
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
        // dd($validated);

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
            return redirect()->back()->with('success', AlertHelper::message("Le produit $request->nomprod a bien été enregistré", "success"));
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

    public function one($idproduit)
    {
        $idproduit = IdEncryptor::decode($idproduit);
        $prod = Produit::with('danger', 'infofds')->find($idproduit);
        return view('product.one', compact('prod'));
    }

    public function edit($idproduit)
    {
        $allDangers = Danger::all();
        $infoproduit = Produit::with('danger')->findOrFail($idproduit);
        return view('product.edit', compact('infoproduit', 'allDangers'));
    }

    public function editPost(Request $request, $idproduit)
    {
        $validated = $request->validate([
            'nomprod' => ['required', 'string', 'max:255', Rule::unique('produit', 'nomprod')->ignore($idproduit)],
            'type_emballage' => ['required', 'string', 'max:255'],
            'poids' => ['required', 'string', 'max:255'],
            'nature' => ['required', 'string', 'max:255'],
            'utilisation' => ['required', 'string', 'max:255'],
            'fabricant' => ['required', 'string', 'max:255'],
            'photo' => ['nullable', 'file', 'image', 'mimes:jpg,jpeg,png,gif'],
            'fds' => ['nullable', 'file', 'mimes:pdf'],
            'risque' => ['required', 'string', 'max:255'],
            'danger' => 'required|array',
        ]);
        // dd($validated, $request->all());

        $produit = Produit::findOrFail($idproduit);


        // Vérification et traitement de la photo
        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');

            // Vérifie la taille (max 8 Mo)
            if ($photo->getSize() > 5 * 1024 * 1024) {
                return back()->with('error', 'La photo dépasse la taille maximale autorisée (5 Mo).');
            }

            // Supprime l'ancienne photo si elle existe
            if ($produit->photo && Storage::disk('public')->exists($produit->photo)) {
                Storage::disk('public')->delete($produit->photo);
            }


            $photoPath = $photo->store('uploads/photo', 'public');
            $produit->photo = $photoPath;
        }

        // Vérification et traitement de la FDS
        if ($request->hasFile('fds')) {
            $fds = $request->file('fds');

            // Vérifie la taille (max 10 Mo)
            if ($fds->getSize() > 10 * 1024 * 1024) {
                return back()->with('error', 'Le fichier FDS dépasse la taille maximale autorisée (10 Mo).');
            }

            // Supprime l'ancienne FDS si elle existe
            if ($produit->fds && Storage::disk('public')->exists($produit->fds)) {
                Storage::disk('public')->delete($produit->fds);
            }


            $fdsPath = $fds->store('uploads/fds', 'public');
            $produit->fds = $fdsPath;
        }

        // Mise à jour des autres champs
        $produit->nomprod = strtoupper($request->input('nomprod'));
        $produit->type_emballage = strtoupper($request->input('type_emballage'));
        $produit->poids = strtoupper($request->input('poids'));
        $produit->nature = strtoupper($request->input('nature'));
        $produit->utilisation = strtoupper($request->input('utilisation'));
        $produit->fabricant = strtoupper($request->input('fabricant'));
        $produit->risque = strtoupper($request->input('risque'));

        $produit->save();

        // Mise à jour des dangers liés
        $produit->danger()->sync($request->input('danger'));
        // dd($produit->photo);

        return redirect()->back()->with('successEdit', AlertHelper::message("Le produit $request->nomprod a bien été modifié", "success"));
    }

}
