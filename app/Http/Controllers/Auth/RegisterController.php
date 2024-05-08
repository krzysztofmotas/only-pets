<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controller;

class RegisterController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function register()
    {
        return view('auth.register');
    }

    public function handle(Request $request)
    {
        $validatedData = $request->validate([
            'display_name' => ['required', 'string', 'max:40'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:4', 'confirmed'],
        ]);

        $displayName = $validatedData['display_name'];

        $user = User::create([
            'name' => User::generateUniqueName($displayName),
            'display_name' => $displayName,
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password'])
        ]);

        Auth::login($user);

        $request->session()->regenerate();
        return redirect('/');
    }
}
