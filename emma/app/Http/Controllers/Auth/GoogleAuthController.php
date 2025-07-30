<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;

class GoogleAuthController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->stateless()->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->stateless()->user();

            $user = User::updateOrCreate(
                ['email' => $googleUser->getEmail()],
                [
                    'name' => $googleUser->getName(),
                    'google_id' => $googleUser->getId(),
                    'email_verified_at' => now(),
                    'password' => bcrypt(Str::random(16)), // senha aleatória
                ]
            );

            Auth::login($user);

            return redirect()->to('http://localhost:5173/google/callback?token=' . $user->createToken('auth_token')->plainTextToken);
        } catch (\Exception $e) {
            \Log::error('Erro Google Login: ' . $e->getMessage());
            return response()->json(['error' => 'Erro ao autenticar com o Google.'], 500);
        }
    }
}
