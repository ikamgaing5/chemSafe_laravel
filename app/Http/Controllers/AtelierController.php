<?php

namespace App\Http\Controllers;

use App\Models\Usine;
use App\Models\Atelier;
use Illuminate\Http\Request;
use App\Helpers\AlertHelper;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Http\JsonResponse;

// use Illuminate\Support\Facades\Auth as FacadesAuth;

class AtelierController extends Controller
{
    public function all($idusine)
    {
        $idusine = Crypt::decrypt($idusine);
        $usine = Usine::find($idusine);
        $workshop = Atelier::withCount([
            'contenir',
            'produitSansFds'
        ])->orderBy('nomatelier', 'asc')->where('usine_id', $idusine)->get();
        $AllUsine = Usine::where('active', 1)->orderBy('nomusine', 'asc')->get();
        if (Auth::user()->role == 'superadmin') {
            $nbreAtelier = Atelier::where('usine_id', $idusine)->where('active', 'true')->count();
        } else {
            $nbreAtelier = Atelier::where('usine_id', $idusine)->where('active', 'true')->count();
        }
        return view('workshop.all', compact('workshop', 'nbreAtelier', 'AllUsine', 'usine', 'idusine'));
    }

    public function alls()
    {
        $AllUsine = Usine::where('active', true)->orderBy('nomusine', 'asc')->get();

        return view('workshop.alls', compact('AllUsine'));
    }

    public function delete(Request $request, $id)
    {
        $request->validate([
            'active' => 'required|string|in:true,false',
        ]);
        $atelier = Atelier::findOrFail($id);

        // Vérifier si l'atelier a des produits associés
        if ($atelier->contenir()->count() > 0) {
            return back()->with('echecDelete', AlertHelper::message('Cet atelier contient au moins un produit et ne peut-être effacé', 'danger'));
        }

        $atelier->update(['active' => $request->active]);

        return back()->with('deleteSuccess', AlertHelper::message("L'atelier <strong> $atelier->nomatelier </strong> a bien été effacé", 'success'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nomatelier' => [
                'required',
                'string',
                'max:255',
                Rule::unique('atelier', 'nomatelier')->ignore($id)->where(function ($query) use ($request) {
                    return $query->where('usine_id', $request->input('usine_id'));
                }),
            ]
        ]);

        $atelier = Atelier::findOrFail($id);
        $old = strtoupper($request->input('oldvalue'));
        $new = strtoupper($request->input('nomatelier'));
        if ($old === $new) {
            return back()->with('samename', AlertHelper::message("Cet atelier existe déjà", "danger"));
        }
        $atelier->update(['nomatelier' => strtoupper($new)]);
        return back()->with('updateOk', AlertHelper::message("L'atelier <strong> $old </strong> a été modifié en <strong> $new </strong> avec succès", "success"));
    }

    public function add(Request $request)
    {
        try {
            $validated = $request->validate([
                'nomatelier' => [
                    'required',
                    'string',
                    'max:255',
                    Rule::unique('atelier', 'nomatelier')
                        ->where(function ($query) use ($request) {
                            return $query->where('usine_id', $request->usine_id);
                        }),
                ],
                'usine_id' => ['required', 'string'],
            ], [
                'nomatelier.unique' => 'Ce nom d\'atelier existe déjà pour cette usine.',
                'nomatelier.required' => 'Le nom de l\'atelier est requis.',
            ]);
            $atelier = Atelier::create(['nomatelier' => strtoupper($request->input('nomatelier'))]);
            return back()->with('successadd', AlertHelper::message("L'atelier <strong>{$validated['nomatelier']}</strong> a été ajoutée avec succès.", "success"));
        } catch (\Illuminate\Validation\ValidationException $e) {
            if ($e->validator->errors()->first('nomatelier') == "validation.unique") {
                $message = "L'atelier {$request->input('nomatelier')} existe déjà";
            }
            return back()
                ->withErrors($e->validator)
                ->withInput()
                ->with('erroradd', AlertHelper::message($message ?? $e->validator->errors()->first('nomatelier'), 'danger'));
        }
    }


    public static function getAteliers($idusine)
    {
        $results = DB::table('atelier as a')
            ->leftJoin('contenir as c', 'a.id', '=', 'c.atelier_id')
            ->leftJoin('produit as p', 'c.produit_id', '=', 'p.id')
            ->where('a.usine_id', $idusine)
            ->select(
                'a.id',
                'a.nomatelier as nom_atelier',
                DB::raw('COUNT(DISTINCT p.id) as total_produits'),
                DB::raw("SUM(CASE 
                            WHEN p.id IS NOT NULL AND p.fds IS NOT NULL AND p.fds != '' 
                            THEN 1 ELSE 0 
                         END) as produits_avec_fds"),
                DB::raw("SUM(CASE 
                            WHEN p.id IS NOT NULL AND (p.fds IS NULL OR p.fds = '') 
                            THEN 1 ELSE 0 
                         END) as produits_sans_fds")
            )
            ->groupBy('a.id', 'a.nomatelier')
            ->orderBy('a.nomatelier')->where('a.active', 'true' )
            ->get();

        return response()->json($results);
    }


    public function getAteliersWithDetailsAll(): JsonResponse
    {
        $results = DB::table('atelier as a')
            ->leftJoin('contenir as c', 'a.id', '=', 'c.atelier_id')
            ->leftJoin('produit as p', 'c.produit_id', '=', 'p.id')
            ->join('usine as u', 'a.usine_id', '=', 'u.id')
            ->select(
                'a.id as idatelier',
                'a.nomatelier as nom_atelier',
                'u.id as idusine',
                'u.nomusine',
                DB::raw('COUNT(DISTINCT p.id) as total_produits'),
                DB::raw("SUM(CASE WHEN p.id IS NOT NULL AND p.fds IS NOT NULL AND p.fds != '' THEN 1 ELSE 0 END) as produits_avec_fds"),
                DB::raw("SUM(CASE WHEN p.id IS NOT NULL AND (p.fds IS NULL OR p.fds = '') THEN 1 ELSE 0 END) as produits_sans_fds"),
                DB::raw("(
                    SELECT COUNT(DISTINCT c2.produit_id)
                    FROM atelier a2
                    LEFT JOIN contenir c2 ON a2.id = c2.atelier_id
                    WHERE a2.usine_id = a.usine_id
                ) as total_usine")
            )
            ->groupBy('a.id', 'a.nomatelier', 'u.id', 'u.nomusine')
            ->orderBy('u.nomusine')
            ->orderBy('a.nomatelier')
            ->get();
    
        return response()->json($results);
    }
    



}