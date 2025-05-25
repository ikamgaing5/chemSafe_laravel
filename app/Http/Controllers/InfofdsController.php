<?php

namespace App\Http\Controllers;

use App\Helpers\AlertHelper;
use App\Models\Produit;
use App\Models\FDS;
use Illuminate\Http\Request;

class InfofdsController extends Controller
{
       public function add(Request $request, $idproduit)
       {
              $produit = Produit::find($idproduit);
              return view('infofds.add', compact('idproduit', 'produit'));
       }

       public function addPost(Request $request)
       {
              $validated = $request->validate([
                     'produit_id' => ['required'],
                     'physique' => ['required', 'string', 'max:255'],
                     'sante' => ['required', 'string', 'max:255'],
                     'ppt' => ['required', 'string', 'max:255'],
                     'stabilite' => ['required', 'string', 'max:255'],
                     'eviter' => ['required', 'string', 'max:255'],
                     'incompatible' => ['required', 'string', 'max:255'],
                     'reactivite' => ['required', 'string', 'max:255'],
                     'stockage' => ['required', 'string', 'max:255'],
                     'secours' => ['required', 'string', 'max:255'],
                     'epi' => ['required', 'string', 'max:255'],
              ]);

              $infoFds = FDS::create([
                     'produit_id' => $request->input('produit_id'),
                     'physique' => strtoupper($request->input('physique')),
                     'sante' => strtoupper($request->input('sante')),
                     'ppt' => strtoupper($request->input('ppt')),
                     'stabilite' => strtoupper($request->input('stabilite')),
                     'eviter' => strtoupper($request->input('eviter')),
                     'incompatible' => strtoupper($request->input('incompatible')),
                     'reactivite' => strtoupper($request->input('reactivite')),
                     'stockage' => strtoupper($request->input('stockage')),
                     'secours' => strtoupper($request->input('secours')),
                     'epi' => strtoupper($request->input('epi')),
              ]);
              return redirect()->back()->with('addFDSSuccess', AlertHelper::message("Les informations de la FDS ont été bien enregistrées", "success"));

       }

       public function edit($id, $idatelier)
       {
              $fds = FDS::with('produit')->findOrFail($id);
              return view('infofds.edit', compact('fds', 'idatelier'));
       }

       public function editPost(Request $request, $id)
       {
              $validated = $request->validate([
                     'physique' => ['required', 'string', 'max:255'],
                     'sante' => ['required', 'string', 'max:255'],
                     'ppt' => ['required', 'string', 'max:255'],
                     'stabilite' => ['required', 'string', 'max:255'],
                     'eviter' => ['required', 'string', 'max:255'],
                     'incompatible' => ['required', 'string', 'max:255'],
                     'reactivite' => ['required', 'string', 'max:255'],
                     'stockage' => ['required', 'string', 'max:255'],
                     'secours' => ['required', 'string', 'max:255'],
                     'epi' => ['required', 'string', 'max:255'],
              ]);
              // dd($validated);
              $infofds = FDS::findOrFail($id);
              $idatelier = $request->input('idatelier');

              $infofds->update([
                     'sante' => strtoupper($request->input('sante')),
                     'physique' => strtoupper($request->input('physique')),
                     'ppt' => strtoupper($request->input('ppt')),
                     'stabilite' => strtoupper($request->input('stabilite')),
                     'eviter' => strtoupper($request->input('eviter')),
                     'incompatible' => strtoupper($request->input('incompatible')),
                     'reactivite' => strtoupper($request->input('reactivite')),
                     'manipulation' => strtoupper($request->input('manipulation')),
                     'secours' => strtoupper($request->input('secours')),
                     'epi' => strtoupper($request->input('epi')),
              ]);

              return redirect()->route('product.one', [$idatelier, $infofds->produit_id])->with('updateInfoFDS', AlertHelper::message("Les informations de la FDS ont bien été modifiées", "success"));
       }
}
