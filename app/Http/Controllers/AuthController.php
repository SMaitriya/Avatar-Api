<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $fields = $request->validate([
            'pseudo' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|confirmed|min:6'
        ]);

        $user = User::create([
            'pseudo' => $fields['pseudo'],
            'email' => $fields['email'],
            'password' => bcrypt($fields['password']),
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'user' => $user,
            'token' => $token
        ], 201);
    }

    public function login(Request $request)
    {
        $fields = $request->validate([
            'pseudo' => 'required|string',
            'password' => 'required|string'
        ]);

        $user = User::where('pseudo', $fields['pseudo'])->first();

        if (!$user || !Hash::check($fields['password'], $user->password)) {
            return response()->json(['message' => 'Identifiants invalides'], 401);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'user' => $user,
            'token' => $token
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json([
            'message' => 'Déconnecté avec succès'
        ]);
    }

    public function user(Request $request)
    {
        $user = $this->getAuthenticatedUser($request);
        return $user ?: response()->json(['message' => 'Unauthenticated'], 401);
    }

    protected function getAuthenticatedUser(Request $request)
    {
        $token = $this->getTokenFromRequest($request);
        if (!$token) {
            return null;
        }

        $user = \Laravel\Sanctum\PersonalAccessToken::findToken($token)->tokenable;
        return $user ? ['id' => $user->id, 'pseudo' => $user->pseudo, 'is_admin' => (bool)$user->is_admin] : null;
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
