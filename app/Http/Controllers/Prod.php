<?php
// app/Http/Controllers/ProductController.php
namespace App\Http\Controllers;

use App\Models\Produit;
use App\Models\Atelier;
use App\Models\Usine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class Prod extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    public function index(Request $request)
    {
        $user = Auth::user();
        $search = $request->get('search', '');
        $page = $request->get('page', 1);
        $limit = 30;

        // Déterminer l'ID usine selon le rôle
        $idusine = $user->role == "superadmin" ? null : $user->usine_id;

        // Construction de la requête
        $query = Produit::withWorkshopDetails($idusine);

        if (!empty($search)) {
            $query->search($search);
        }

        // Pagination

        
        $produits = $query->paginate($limit, ['*'], 'page', $page);
        $produits->appends($request->query());
        $total_pages = $produits->lastPage();
        $current_page = $produits->currentPage();

        // Traitement des données selon le rôle
        $data = [
            'produits' => $produits,
            'search' => $search,
            'user' => $user,
        ];

        if ($user->role == "superadmin") {
            // Grouper par usine pour superadmin
            $data['produitsParUsine'] = $this->groupByUsine($produits->items());
        } else {
            // Séparer produits communs et par atelier pour admin
            $data = array_merge($data, $this->separateByWorkshop($produits->items()));
        }
        $message = "Tous les produits";

        return view('product.index', $data, compact('message'));
    }

    public function show($id)
    {
        try {
            $id = Crypt::decrypt($id);
            $produit = Produit::with(['ateliers.usine'])->findOrFail($id);

            return view('products.show', compact('produit'));
        } catch (\Exception $e) {
            return redirect()->route('products.index')
                ->with('error', 'Produit introuvable');
        }
    }

    private function groupByUsine($produits)
    {
        $produitsParUsine = [];
        foreach ($produits as $produit) {
            $usine = $produit->nom_usine;
            if (!isset($produitsParUsine[$usine])) {
                $produitsParUsine[$usine] = [];
            }
            $produitsParUsine[$usine][] = $produit;
        }
        return $produitsParUsine;
    }
    private function separateByWorkshop($produits)
    {
        $parAtelier = [];
        $communs = [];

        foreach ($produits as $produit) {
            if ($produit->nb_ateliers > 1) {
                $communs[] = $produit;
            } else {
                $ateliers = $produit->ateliers;
                if (!isset($parAtelier[$ateliers])) {
                    $parAtelier[$ateliers] = [];
                }
                $parAtelier[$ateliers][] = $produit;
            }
        }

        return [
            'parAtelier' => $parAtelier,
            'communs' => $communs
        ];
    }
}

// app/Providers/AuthServiceProvider.php (Ajouter cette méthode dans boot())

