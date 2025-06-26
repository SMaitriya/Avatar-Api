<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AvatarController extends Controller
{
    /**
     * Exemple : Enregistre la configuration d'un avatar dans la base ou retourne la config.
     */
    public function create(Request $request)
    {
        $fields = $request->validate([
            'name' => 'required|string|max:50',
            'nose_size' => 'required|string|max:50',
            'eye_type' => 'required|string|max:50',
            'eye_color' => 'required|string|max:50',
            'eye_size' => 'required|string|max:50',
            'eyebrow_type' => 'required|string|max:50',
            'eyebrow_color' => 'required|string|max:50',
            'hair_type' => 'required|string|max:50',
            'hair_color' => 'required|string|max:50',
            'mouth_type' => 'nullable|string|max:50',
            'mouth_size' => 'required|string|max:50',
            'beard_type' => 'required|string|max:50',
            'beard_color' => 'nullable|string|max:50',
            'shirt_color' => 'required|string|max:50',
            'glasses_type' => 'nullable|string|max:50',
            'accessory_type' => 'nullable|string|max:50',
            'background_type' => 'nullable|string|max:50',
            'skin_color' => 'required|string|max:50',
            'nose_type' => 'required|string|max:50',
        ]);

        // Ici tu pour  sauvegarder la config en base :
        // Avatar::create([
        //     'user_id' => auth()->id(),
        //     'config' => json_encode($fields),
        // ]);

        // Ou simplement renvoyer la configuration validée
        return response()->json([
            'avatar_data' => $fields
        ]);
    }
}
