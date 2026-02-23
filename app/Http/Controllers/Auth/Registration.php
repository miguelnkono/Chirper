<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class Registration extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        // validate the request parameters
        $validation = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
            ],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                'unique:users',
            ],
            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
            ],
        ]);

        // create the user
        $user = User::create([
            'name' => $validation['name'],
            'email' => $validation['email'],
            'password' => Hash::make($validation['password']),
        ]);

        // log the user in
        Auth::login($user);

        // redirect to the home page
        return redirect('/')->with('success', 'Welcome to Chirper');
    }
}
