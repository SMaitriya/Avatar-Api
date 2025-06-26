<?php

namespace App\Http\Controllers;

use App\Models\AvatarComplet;
use Illuminate\Http\JsonResponse;

class AvatarApiController extends Controller
{
    public function allAvatarsMinimal(): JsonResponse
    {
        // Récupérer seulement les colonnes voulues
        $avatars = AvatarComplet::select('avatar_name', 'avatar_svg')->get();

        // Retourner la réponse JSON
        return response()->json($avatars);
    }
}
