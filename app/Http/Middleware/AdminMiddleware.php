<?php

namespace App\Http\Middleware;

use Closure;
use Laravel\Sanctum\PersonalAccessToken;

class AdminMiddleware
{
     // Middleware pour vérifier si l'utilisateur est admin
    public function handle($request, Closure $next)
    {
        $user = $this->getCurrentUser($request);
        if (!$user || !$user['is_admin']) {
            return $request->expectsJson()
                ? response()->json(['message' => 'Accès non autorisé'], 403)
                : redirect('/')->with('error', 'Accès non autorisé');
        }
        return $next($request); // Laisse passer la requête si admin
    }

    // Récupère l'utilisateur courant à partir du token d'accès
    private function getCurrentUser($request)
    {
        $token = $this->getTokenFromRequest($request);
        if (!$token) {
            return null;
        }

        try {
            $accessToken = PersonalAccessToken::findToken($token); // Cherche le token dans la base
            if (!$accessToken) {
                return null;
            }
            $user = $accessToken->tokenable;
            return $user ? ['id' => $user->id, 'is_admin' => (bool)$user->is_admin] : null;
        } catch (\Exception $e) {
            return null;
        }
    }

    private function getTokenFromRequest($request)
    {
        $header = $request->header('Authorization');
        if ($header && preg_match('/Bearer\s+(\S+)/', $header, $matches)) {
            return $matches[1];
        }
        return $request->session()->get('api_token');
    }
}
