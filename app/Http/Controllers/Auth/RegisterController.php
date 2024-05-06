<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    public function __construct()
    {
        // $this->middleware('guest');
    }

    public function register()
    {
        return view('auth.register');
    }

    public function handle(Request $request)
    {
        $validatedData = $request->validate([ // TODO:
            'display_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
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
