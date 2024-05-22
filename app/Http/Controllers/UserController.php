<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function updateName(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:24|unique:users|regex:/^[^\s]+$/'
        ], [
            'name.unique' => 'Nazwa użytkownika musi być unikalna.',
            'name.regex' => 'Nazwa użytkownika nie może zawierać spacji.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withInput()
                ->withErrors($validator)
                ->with('activeTab', 'name');
        }

        $user = User::findOrFail(Auth::user()->id);
        $user->name = $request->input('name');
        $user->save();

        return redirect()->back()
            ->with('successToast', 'Twoja nazwa została pomyślnie zmieniona.');
    }

    public function updateDisplayName(Request $request) {
        $validator = Validator::make($request->all(), [
            'display-name' => 'required|string|max:40'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withInput()
                ->withErrors($validator)
                ->with('activeTab', 'display-name');
        }

        $user = User::findOrFail(Auth::user()->id);
        $user->display_name = $request->input('display-name');
        $user->save();

        return redirect()->back()
            ->with('successToast', 'Twoja nazwa wyświetlana została pomyślnie zmieniona.');
    }

    public function updatePassword(Request $request) {
        $validator = Validator::make($request->all(), [
            'password' => 'required|current_password',
            'new-password' => 'required|min:4|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withInput()
                ->withErrors($validator)
                ->with('activeTab', 'password');
        }

        $user = User::findOrFail(Auth::user()->id);
        $user->password = Hash::make($request->input('new-password'));
        $user->save();

        return redirect()->back()
            ->with('successToast', 'Twoje hasło zostało pomyślnie zmienione.');
    }

    public function updateOtherInfo(Request $request) {
        $rules = [
            'bio' => 'max:1000',
            'location' => 'max:64',
        ];

        if (!empty($request->input('website-url'))) {
            $rules['website-url'] = 'max:100|active_url';
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()
                ->withInput()
                ->withErrors($validator)
                ->with('activeTab', 'other');
        }

        $user = User::findOrFail(Auth::user()->id);
        $user->bio = $request->input('bio');
        $user->location = $request->input('location');
        $user->website_url = $request->input('website-url');
        $user->save();

        return redirect()->back()
            ->with('successToast', 'Twoje dane zostały pomyślnie zmienione.');
    }

    public function updateAvatar(Request $request) {
        $validator = Validator::make($request->all(), [
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif|max:1000'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->with('activeTab', 'avatar');
        }

        $user = User::findOrFail(Auth::user()->id);

        if ($user->avatar) {
            Storage::delete('avatars/' . $user->avatar);
        }

        $file = $request->file('avatar');
        $path = Storage::putFile('public/images/avatars', $file);
        $user->avatar = basename($path);
        $user->save();

        return redirect()->back()
            ->with('successToast', 'Twój awatar został pomyślnie zmieniony.');
    }

    public function deleteAvatar() {
        $user = User::findOrFail(Auth::user()->id);

        if ($user->avatar) {
            Storage::delete('public/images/avatars/' . $user->avatar);
        }

        $user->avatar = null;
        $user->save();

        return redirect()->back()
            ->with('successToast', 'Twój awatar został pomyślnie usunięty.');
    }

    public function updateBackground(Request $request) {
        $validator = Validator::make($request->all(), [
            'background' => 'required|image|mimes:jpeg,png,jpg,gif|max:1000'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->with('activeTab', 'background');
        }

        $user = User::findOrFail(Auth::user()->id);

        if ($user->background) {
            Storage::delete('backgrounds/' . $user->background);
        }

        $file = $request->file('background');
        $path = Storage::putFile('public/images/backgrounds', $file);
        $user->background = basename($path);
        $user->save();

        return redirect()->back()
            ->with('successToast', 'Twoje zdjęcie w tle zostało pomyślnie zmienione.');
    }

    public function deleteBackground() {
        $user = User::findOrFail(Auth::user()->id);

        if ($user->background) {
            Storage::delete('public/images/backgrounds/' . $user->background);
        }

        $user->background = null;
        $user->save();

        return redirect()->back()
            ->with('successToast', 'Twoje zdjęcie w tle zostało pomyślnie usunięte.');
    }

    public function profile(User $user) {
        $suggestedUsers = User::getSuggestedUsers();
        return view('home.profile', compact('user', 'suggestedUsers'));
    }
}
