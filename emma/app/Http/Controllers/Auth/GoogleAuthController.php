<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\AuthorizedEmail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;

class GoogleAuthController extends Controller
{
    public function redirectToGoogle()
    {
        Log::info('Redirecionando para Google...');
        return Socialite::driver('google')->redirect(); // NÃO use stateless
    }

    public function handleGoogleCallback(Request $request)
    {
        try {
            $googleUser = Socialite::driver('google')->stateless()->user();

            $authorized = AuthorizedEmail::where('email', $googleUser->getEmail())->exists();

            if (!$authorized) {
                return response()->json(['message' => 'E-mail não autorizado.'], 403);
            }
            
            // Cria ou atualiza o usuário
            $user = User::updateOrCreate(
                ['email' => $googleUser->getEmail()],
                [
                    'name' => $googleUser->getName(),
                    'google_id' => $googleUser->getId(),
                    'avatar' => $googleUser->getAvatar(),
                    'role' => $googleUser->getEmail() === 'eva01.gustavo@gmail.com' ? 'admin' : 'user', 
                ]
            );

            // Autentica e gera token Sanctum
            Auth::login($user);
            $token = $user->createToken('authToken')->plainTextToken;

            // Retorna apenas os dados públicos necessários
            $safeUser = [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role,
            ];

            return redirect()->away("http://localhost:5173/google/callback?token={$token}&user=" . urlencode(json_encode($safeUser)));

        } catch (\Exception $e) {
            \Log::error("Erro Google Login: " . $e->getMessage());
            return redirect()->away("http://localhost:5173/login?error=google_auth_failed");
        }
    }


    public function registerFromGoogle(Request $request)
    {
        $validated = $request->validate([
            'role' => 'required|in:admin,hr',
        ]);

        $googleUser = session('google_user');

        if (!$googleUser) {
            return response()->json(['error' => 'Sessão expirada.'], 419);
        }

        $user = User::create([
            'name' => $googleUser['name'],
            'email' => $googleUser['email'],
            'role' => $validated['role'],
            'password' => bcrypt(Str::random(16)),
        ]);

        Auth::login($user);
        session()->forget('google_user');
        session()->regenerate();

        return redirect(env('FRONTEND_URL') . '/dashboard');
    }
}