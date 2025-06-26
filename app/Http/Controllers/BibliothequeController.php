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

    public function recuperer()
    {
        $avatars = AvatarComplet::where('user_id', Auth::id())->get();
        return response()->json($avatars);
    }

        public function allAvatars()
    {
        $avatars = AvatarComplet::all();
        return response()->json($avatars);
    }

    

    public function delete($id)
    {
        $user = Auth::user();

        $avatar = AvatarComplet::where('avatar_id', $id)
            ->where('user_id', $user->id)
            ->first();

        if (!$avatar) {
            return response()->json(['message' => 'Avatar non trouvé ou accès refusé'], 404);
        }

        try {
            $avatar->delete();
            return response()->json(['message' => 'Avatar supprimé avec succès']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Erreur lors de la suppression'], 500);
        }
    }
}
