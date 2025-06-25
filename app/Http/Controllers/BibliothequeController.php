<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Avatar;

class BibliothequeController extends Controller
{
       public function index() // Récupérer tous les avatars de l'utilisateur connecté sans doute utile pour la bibliothèque
    {
        $avatars = AvatarComplet::where('user_id', Auth::id())->get();
        return response()->json($avatars);
    }

}
