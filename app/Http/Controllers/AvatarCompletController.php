<?php

namespace App\Http\Controllers;

use App\Models\AvatarComplet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AvatarCompletController extends Controller
{
    // Enregistre un nouvel avatar complet pour l'utilisateur connecté
    public function store(Request $request)
    {

        $request->validate([
            'avatar_svg' => 'required|string',
            'avatar_name' => 'required|string|max:255',
        ]);

        // Création de l'avatar en base de données
        $avatar = AvatarComplet::create([
            'user_id' => Auth::id(),
            'avatar_svg' => $request->avatar_svg,
            'avatar_name' => $request->avatar_name,
        ]);

        return response()->json([
            'message' => 'Avatar sauvegardé avec succès.',
            'avatar_id' => $avatar->avatar_id,
            'avatar_name' => $avatar->avatar_name,
        ], 201);
    }

    // Récupérer tous les avatars de l'utilisateur connecté sans doute utile pour la bibliothèque
    public function index() 
    {
        $avatars = AvatarComplet::where('user_id', Auth::id())->get();
        return response()->json($avatars);
    }
}
