<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\ApiKey;
use Illuminate\Support\Facades\Log;

class ApiKeyMiddleware
{
    // Middleware pour vérifier la présence et la validité d'une clé API
    public function handle(Request $request, Closure $next)
    {
        // Récupère la clé API depuis le bearer token
        $apiKey = $request->bearerToken()
            ?? $request->header('X-API-KEY')
            ?? $request->query('api_key');

        Log::info('API KEY recue', ['apiKey' => $apiKey]);

        // Recherche une clé API active correspondante en base
        $key = ApiKey::where('cle_api', $apiKey)->where('status', 'Actif')->first();
        Log::info('Key trouvé', ['key' => $key]);

        if (!$key) {
            return response()->json(['message' => 'Clé API invalide ou manquante'], 401);
        }

        return $next($request);
    }
}
