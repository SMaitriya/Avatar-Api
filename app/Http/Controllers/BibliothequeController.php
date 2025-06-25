<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AvatarComplet;
use Illuminate\Support\Facades\Auth;


class BibliothequeController extends Controller
{

    public function index()
    {
        return view('bibliotheque');
    }


       public function recuperer() // Récupérer tous les avatars de l'utilisateur connecté sans doute utile pour la bibliothèque
    {
        $avatars = AvatarComplet::where('user_id', Auth::id())->get();
        return response()->json($avatars);
    }

}
