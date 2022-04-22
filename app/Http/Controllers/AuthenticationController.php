<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\PersonalAccessToken;

class AuthenticationController extends Controller
{
    public function register(Request $request)
    {
        $attr = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users,email',
            'password' => 'required'
        ]);

        $user = User::create([
            'name' => $attr['name'],
            'password' => bcrypt($attr['password']),
            'email' => $attr['email'],
            'slug' => str_replace(' ', '-', strtolower($attr['name']))
        ]);

        return response()->json([
            'token' => $user->createToken('tokens')->plainTextToken
        ]);
    }
    //use this method to signin users
    public function login(Request $request)
    {

        $attr = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string|min:6'
        ]);

        if (!Auth::attempt($attr)) {
            return response()->json("Neveljavni podatki");
        }
        // dva valid tokena na admina
        $validTokenIds = PersonalAccessToken::
            where('tokenable_id', admin()->id)
            ->orderBy("last_used_at", 'desc')
            ->take(1)
            ->pluck('id');
        PersonalAccessToken::where('tokenable_id', admin()->id)->whereNotIn('id', $validTokenIds)->delete();

        return response()->json([
            'token' => auth()->user()->createToken('API Token')->plainTextToken
        ]);
    }

    // this method signs out users by removing tokens
    public function signout()
    {
        auth()->user()->tokens()->delete();

        return [
            'message' => 'Tokens Revoked'
        ];
    }
}
