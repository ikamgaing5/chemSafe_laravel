<?php

namespace App\Http\Controllers;

use App\Helpers\AlertHelper;
use App\Models\historique;
use App\Models\Usine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserController extends Controller
{
    public function dashboard()
    {
        $usine = Usine::findOrFail(Auth::user()->usine_id);
        return view('user.dashboard', compact('usine'));
    }

    public function home()
    {
        return view('index', ['title' => 'ChemSafe']);
    }

    public function add()
    {
        $usinesSansUtilisateur = Usine::doesntHave('users')->where('active', 'true')->get();
        $usine = Usine::where('active', 'true');
        return view('user.add', compact('usinesSansUtilisateur', 'usine'));
    }

    public function store(Request $request)
    {
        try {
            // Validation des données
            $request->validate([
                'username' => 'required|unique:users,username',
                'name' => 'required',
                'role' => 'required|in:admin,user',
                'usine' => 'required|exists:usine,id',
                'password' => 'required|min:8|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/',
                'password_confirmation' => 'required|same:password'
            ], [
                'username.unique' => 'Ce nom d\'utilisateur est déjà utilisé.',
                'password.regex' => 'Le mot de passe doit contenir au moins 8 caractères, une majuscule, une minuscule, un chiffre et un caractère spécial.',
                'password_confirmation.same' => 'Les mots de passe ne correspondent pas.',
                'usine.exists' => 'L\'usine sélectionnée n\'existe pas.'
            ]);

            // Création de l'utilisateur
            $user = User::create([
                'username' => $request->username,
                'name' => $request->name,
                'role' => $request->role,
                'usine_id' => $request->usine,
                'password' => Hash::make($request->password)
            ]);

            // Enregistrement pour l'historique
            historique::create([
                'user_id' => User::user()->id,
                'created_by' => Auth::user()->id,
                'type' => 1,  // 1 pour la création et 0 pour la suppression
                'action' => "Création de l'utilisateur $request->name",
                'created_at' => now(),
            ]);

            // Message de succès
            return redirect()->back()->with('createSuccess', AlertHelper::message("L'utilisateur a été crée avec succès", "success"));

        } catch (\Illuminate\Validation\ValidationException $e) {
            // En cas d'erreur de validation
            return redirect()->back()
                ->withErrors($e->validator)
                ->withInput();
        } catch (\Exception $e) {
            // En cas d'autres erreurs
            return redirect()->back()
                ->with('createSuccess', AlertHelper::message("Une erreur est survenue lors de la création de l'utilisateur", "danger"))
                ->withInput();
        }
    }
}
