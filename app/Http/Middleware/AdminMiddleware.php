<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\historique_acces as Historique;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
        // Durée maximale d'inactivité en secondes (20 minutes ici)
        protected $timeout = 1200;

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect()->route('start')->with('pasacces', true); // ou '/login'
        }

        if (Auth::check()) {
            $lastActivity = session('lastActivityTime');

            if ($lastActivity && (time() - $lastActivity) > $this->timeout) {

                Historique::create([
                    'user_id' => Auth::id() ,
                    'created_at' => now()->toDateString(),
                    'action' => "Inactivité",
                    'time' => now()->format('H:i:s'),
                ]);

                Auth::logout(); // Déconnecte l'utilisateur
                session()->flush(); // Vide la session
                return redirect()->route('start')->with('offff', true);
            }

            // Met à jour l'horodatage de la dernière activité
            session(['lastActivityTime' => time()]);
        }


        if (Auth::user()->role == "admin" || Auth::user()->role == "superadmin" ) {
            return $next($request);
        }

        return redirect()->back();
    }
}
