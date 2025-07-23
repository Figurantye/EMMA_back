<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Session;


class AuthController extends Controller
{
    /**
     * Registra um novo usuário
     */
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'hr',
        ]);

        Auth::login($user);

        return response()->json(['message' => 'Usuário registrado com sucesso'], 201);
    }

    /**
     * Realiza login do usuário
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (!Auth::attempt($credentials)) {
            throw ValidationException::withMessages([
                'email' => ['As credenciais estão incorretas.'],
            ]);
        }

        // Invalida a sessão anterior e gera uma nova
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        $request->session()->regenerate(); // este é o mais importante

        return response()->json(['message' => 'Login realizado com sucesso']);
    }

    /**
     * Retorna o usuário autenticado
     */
    public function user(Request $request)
    {
        return response()->json($request->user());
    }

    /**
     * Realiza logout do usuário atual
     */
    public function logout(Request $request)
    {
        Auth::guard('web')->logout();

        // Limpa tudo
        Session::flush();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->json(['message' => 'Logout realizado com sucesso']);
    }
}
