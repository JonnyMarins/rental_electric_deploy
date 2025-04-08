<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Http\Requests\Auth\LoginRequest;

class AuthController extends Controller
{
    /**
     *  Registra un utente
     */
    public function register(RegisterRequest $request)
    {
        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);
        return response()->json([
            'message' => 'L\'utente è stato registrato con successo',
            'user' => $user
        ], 201);
    }

    /**
     * Autentica un utente esistente
     */
    public function login(LoginRequest $request)
    {
        if (!Auth::attempt($request->only('email', 'password'))) {
            throw ValidationException::withMessages([
                'message' => ['Le credenziali fornite non sono corrette.']
            ]);
        }
        $user = $request->user();
        $token = $user->createToken('web-app', ['vehicles:create'])->plainTextToken;

        return response()->json([
            'user' => $user,
            'token' => $token
        ]);
    }

    /**
     * Ottiene i dati dell'utente autenticato
     */
    public function user(Request $request)
    {
        return response()->json([
            'user' => $request->user()
        ]);
    }

    /**
     * Effettua il logout (revoca il token corrente)
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(
            ['message' => 'Logout effettuato con successo']
        );
    }

    /**
     * Effettua il logout da tutti i dispositivi (revoca tutti i token)
     */
    public function logoutAll(Request $request)
    {
        $request->user()->tokens()->delete();
        return response()->json(
            ['message' => 'Logout effettuato con successo da tutti i dispositivi']
        );
    }

    /**
     * Recupero la lista di token attivi dell'utente
     */
    public function tokens(Request $request)
    {
        return response()->json([
            'tokens' => $request->user()->tokens
        ]);
    }
}
