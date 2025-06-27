<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\User;



class UserController extends Controller
{
    // Affiche la page de profil de l'utilisateur connecté
    public function showProfile(Request $request)
    {
        $user = Auth::user();

        return view('profil', compact('user'));
    }

    // Met à jour le mot de passe de l'utilisateur connecté
    public function updatePassword(Request $request)
    {
        

        $validator = Validator::make($request->all(), [
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

         $user = Auth::user();
        $user->password = Hash::make($request->password);
        $user->save();

        // Retourne à la page précédente avec un message de succès
        return redirect()->back()->with('status', 'Mot de passe mis à jour avec succès.');
    }

    
}