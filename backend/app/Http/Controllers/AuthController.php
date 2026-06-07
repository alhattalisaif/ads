<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;

class AuthController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->stateless()->redirect();
    }

    public function handleGoogleCallback(Request $request)
    {
        try {
            $googleUser = Socialite::driver('google')->stateless()->user();
        } catch (\Exception $e) {
            return response()->json(['error' => 'Google auth failed', 'details' => $e->getMessage()], 500);
        }

        $user = User::updateOrCreate(
            ['provider' => 'google', 'provider_id' => $googleUser->getId()],
            ['email' => $googleUser->getEmail(), 'name' => $googleUser->getName()]
        );

        // Create wallet if missing
        if (! $user->wallet) {
            $user->wallet()->create();
        }

        // Create token for API usage (Sanctum)
        $token = $user->createToken('api-token')->plainTextToken;

        return response()->json(['token' => $token, 'user' => $user]);
    }
}
