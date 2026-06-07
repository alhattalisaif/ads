<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class AuthController extends Controller
{
    public function googleCallback(Request $request)
    {
        // Stub: accept Google token, validate and create/login user
        // Implementation to be completed: use Socialite or direct token verification.
        return response()->json(['message' => 'Google auth callback - implement using Socialite'], 200);
    }
}
