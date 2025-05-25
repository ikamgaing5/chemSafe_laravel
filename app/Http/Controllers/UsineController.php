<?php

namespace App\Http\Controllers;

use App\Helpers\AlertHelper;
use App\Models\Usine;
use App\Models\Atelier;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UsineController extends Controller
{
    public function all()
    {
        $AllUsine = Usine::where('active', 'true')->with('ateliers')->orderBy('nomusine', 'asc')->get();
        // $AllUsine = Atelier::where('active', 'true')->get();
        return view('factory.all', compact('AllUsine'));
    }

    public function delete(Request $request, $id)
    {
        $usine = Usine::findOrFail($id);
        $request->validate([
            'active' => 'required|string|in:true,false',
        ]);

        if ($usine->ateliers->count() > 0) {
            return back()->with('error', AlertHelper::message("L' <strong> $usine->nomusine </strong> contient au moins un atelier et ne peut-être supprimé", "danger"));
        }
        $usine->update(['active' => $request->active]);
        return back()->with('okay', AlertHelper::message("L' <strong> $usine->nomusine </strong> a été supprimée avec succès", "success"));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nomusine' => ['required', 'string', 'max:255', Rule::unique('usine', 'nomusine')->ignore($id)],
        ]);

        $usine = Usine::findOrFail($id);
        $old = strtoupper($request->input('oldvalue'));
        $new = strtoupper($request->input('nomusine'));

        if ($old === $new) {
            return back()->with('samename', AlertHelper::message("Le nom n'a pas été modifié", "danger"));
        }
        $usine->update(['nomusine' => strtoupper($new)]);
        return back()->with('updateokay', AlertHelper::message("L' <strong> $old </strong> a été modifiée en <strong> $new </strong> avec succès", "success"));
    }

    public function add(Request $request)
    {
        try {
            $validated = $request->validate([
                'nomusine' => [
                    'required',
                    'string',
                    'max:255',
                    Rule::unique('usine', 'nomusine')
                ],
                [
                    'nomusine.unique' => 'Ce nom d\'usine existe déjà dans la base de données.',
                    'nomusine.required' => 'Le nom de l\'usine est requis.',
                ]
            ]);
            Usine::create(['nomusine' => strtoupper($request->input('nomusine'))]);
            $nomUsine = strtoupper($validated['nomusine']);
            return back()->with('successadd', AlertHelper::message("L'<strong>{$nomUsine}</strong> a été ajoutée avec succès.", "success"));
        } catch (\Illuminate\Validation\ValidationException $e) {
            $nomUsine = strtoupper($validated['nomusine']);
            if ($e->validator->errors()->first('nomusine') == "validation.unique" ) {
                $message = "L'{$nomUsine} existe déjà";
            }
            return back()
                ->withErrors($e->validator)
                ->withInput()
                ->with('erroradd', AlertHelper::message($message ?? $e->validator->errors()->first('nomusine'), 'danger'));
        }
    }
}