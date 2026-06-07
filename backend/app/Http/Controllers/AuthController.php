<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;

class AuthController extends Controller
{
    public function redirectToGoogle()
    {
        // Return the OAuth URL so the SPA can open it in a popup
        $redirectUrl = Socialite::driver('google')->stateless()->redirect()->getTargetUrl();
        return response()->json(['url' => $redirectUrl]);
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

        // If this callback is opened in a popup, return a small HTML page that posts the token back to the opener and closes the window.
        $payload = json_encode(['token' => $token, 'user' => $user]);

        $html = "<!doctype html><html><head><meta charset='utf-8'><title>Auth</title></head><body><script>
            (function(){
                var payload = $payload;
                if (window.opener) {
                    window.opener.postMessage(payload, '*');
                }
                // Also write token so manual inspection possible
                document.write('<pre>' + JSON.stringify(payload, null, 2) + '</pre>');
                setTimeout(function(){ window.close(); }, 500);
            })();
        </script></body></html>";

        return response($html, 200)->header('Content-Type', 'text/html');
    }
}
