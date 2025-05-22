<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Models\historique_acces as Historique;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();
        Historique::create([
            'user_id' => Auth::id() ,
            'created_at' => now()->toDateString(),
            'action' => "Connexion",
            'time' => now()->format('H:i:s'),
        ]);

        return redirect()->intended(route('dashboards', absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Historique::create([
            'user_id' => Auth::id() ,
            'created_at' => now()->toDateString(),
            'action' => "Deconnexion",
            'time' => now()->format('H:i:s'),
        ]);

        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/')->with('logout', true);
    }
}