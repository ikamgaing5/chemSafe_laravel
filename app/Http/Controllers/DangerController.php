<?php

namespace App\Http\Controllers;

use App\Models\Danger;
use App\Models\Atelier;
use App\Helpers\IdEncryptor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class DangerController extends Controller
{
    public function getDangerStatsByAtelier($idatelier)
    {
        try {
            // Vérifier si l'atelier existe
            $atelier = Atelier::find($idatelier);
            if (!$atelier) {
                return response()->json(['error' => 'Atelier non trouvé'], 404);
            }

            // Récupérer les statistiques des dangers
            $dangerStats = DB::table('danger')
                ->join('possede', 'danger.id', '=', 'possede.danger_id')
                ->join('produit', 'possede.produit_id', '=', 'produit.id')
                ->join('contenir', 'produit.id', '=', 'contenir.produit_id')
                ->where('contenir.atelier_id', $idatelier)
                ->select('danger.id', 'danger.nomdanger', DB::raw('COUNT(DISTINCT produit.id) as count'))
                ->groupBy('danger.id', 'danger.nomdanger')
                ->orderBy('count', 'DESC')
                ->get();

            // Récupérer les produits par danger
            $productsByDanger = DB::table('danger')
                ->join('possede', 'danger.id', '=', 'possede.danger_id')
                ->join('produit', 'possede.produit_id', '=', 'produit.id')
                ->join('contenir', 'produit.id', '=', 'contenir.produit_id')
                ->where('contenir.atelier_id', $idatelier)
                ->select('danger.id', 'danger.nomdanger', 'produit.id as produit_id', 'produit.nomprod')
                ->orderBy('danger.nomdanger')
                ->orderBy('produit.nomprod')
                ->get()
                ->groupBy('id')
                ->map(function ($group) {
                    return [
                        'id' => $group->first()->id,
                        'nomdanger' => $group->first()->nomdanger,
                        'products' => array_unique($group->pluck('nomprod')->toArray())
                    ];
                });

            // Ajouter la liste des produits à chaque danger dans les statistiques
            $dangerStats->transform(function ($stat) use ($productsByDanger) {
                $stat->products = isset($productsByDanger[$stat->id])
                    ? $productsByDanger[$stat->id]['products']
                    : [];
                return $stat;
            });

            return response()->json($dangerStats);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()], 500);
        }
    }

    public function getDangerStatsAllAteliers()
    {
        $dangerStats = DB::table('danger')
            ->join('possede', 'danger.id', '=', 'possede.danger_id')
            ->join('produit', 'possede.produit_id', '=', 'produit.id')
            ->join('contenir', 'produit.id', '=', 'contenir.produit_id')
            ->select('danger.id', 'danger.nomdanger', DB::raw('COUNT(DISTINCT produit.id) as count'))
            ->groupBy('danger.id', 'danger.nomdanger')
            ->orderBy('count', 'DESC')
            ->get();

        // Récupérer les produits par danger (pour tous ateliers)
        $productsByDanger = DB::table('danger')
            ->join('possede', 'danger.id', '=', 'possede.danger_id')
            ->join('produit', 'possede.produit_id', '=', 'produit.id')
            ->join('contenir', 'produit.id', '=', 'contenir.produit_id')
            ->select('danger.id', 'danger.nomdanger', 'produit.id as produit_id', 'produit.nomprod')
            ->orderBy('danger.nomdanger')
            ->orderBy('produit.nomprod')
            ->get()
            ->groupBy('id')
            ->map(function ($group) {
                return [
                    'id' => $group->first()->id,
                    'encrypted_id' => IdEncryptor::encode($group->first()->id),
                    'nomdanger' => $group->first()->nomdanger,
                    'products' => array_unique($group->pluck('nomprod')->toArray())
                ];
            });

        // Ajouter la liste des produits à chaque danger dans les statistiques
        $dangerStats->transform(function ($stat) use ($productsByDanger) {
            $stat->products = isset($productsByDanger[$stat->id])
                ? $productsByDanger[$stat->id]['products']
                : [];
            $stat->encrypted_id = isset($productsByDanger[$stat->id])
                ? $productsByDanger[$stat->id]['encrypted_id']
                : null;
            return $stat;
        });


        return response()->json($dangerStats);
    }

    public function getDangerStatsByUsine($idusine)
    {
        // Récupérer les dangers et le nombre de produits pour l'usine
        $dangerStats = DB::table('danger')
            ->join('possede', 'danger.id', '=', 'possede.danger_id')
            ->join('produit', 'possede.produit_id', '=', 'produit.id')
            ->join('contenir', 'produit.id', '=', 'contenir.produit_id')
            ->join('atelier', 'contenir.atelier_id', '=', 'atelier.id')
            ->where('atelier.usine_id', $idusine)
            ->select('danger.id', 'danger.nomdanger', DB::raw('COUNT(DISTINCT produit.id) as count'))
            ->groupBy('danger.id', 'danger.nomdanger')
            ->orderBy('count', 'DESC')
            ->get();

        // Récupérer les produits par danger pour cette usine
        $productsByDanger = DB::table('danger')
            ->join('possede', 'danger.id', '=', 'possede.danger_id')
            ->join('produit', 'possede.produit_id', '=', 'produit.id')
            ->join('contenir', 'produit.id', '=', 'contenir.produit_id')
            ->join('atelier', 'contenir.atelier_id', '=', 'atelier.id')
            ->where('atelier.usine_id', $idusine)
            ->select('danger.id', 'danger.nomdanger', 'produit.id as produit_id', 'produit.nomprod')
            ->orderBy('danger.nomdanger')
            ->orderBy('produit.nomprod')
            ->get()
            ->groupBy('id')
            ->map(function ($group) {
                return [
                    'id' => $group->first()->id,
                    'nomdanger' => $group->first()->nomdanger,
                    'products' => array_unique($group->pluck('nomprod')->toArray())
                ];
            });

        // Ajouter la liste des produits à chaque danger dans les statistiques
        $dangerStats->transform(function ($stat) use ($productsByDanger) {
            $stat->products = isset($productsByDanger[$stat->id])
                ? $productsByDanger[$stat->id]['products']
                : [];
            return $stat;
        });

        return response()->json($dangerStats);
    }

    public function getProductByDanger($iddanger){
        $IdEncryptor = IdEncryptor::class;
        $iddanger = IdEncryptor::decode($iddanger);
        // $danger = Danger::where('id', $iddanger)->with('produit')->first();
        $danger = Danger::with('produit')->findOrFail($iddanger);
        if($danger->nomdanger == "AUCUN DANGER"){
            $message = "Liste des produits sans danger.";
        }else{
            $message = "Liste des $danger->nomdanger.";
        }
        
        return view('danger.all', compact('danger', 'message','IdEncryptor'));

    }

    public function all(){
        $IdEncryptor = IdEncryptor::class;
        $danger = Danger::withCount('produit')->orderBy('nomdanger')->get();
        $message = "Liste des Dangers";
        return view('danger.alls', compact('danger', 'message', 'IdEncryptor'));
    }
}