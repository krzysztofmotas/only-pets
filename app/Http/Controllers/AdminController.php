<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function users(Request $request)
    {
        if ($request->has('query')) {
            $query = $request->input('query');

            $users = User::where(function ($q) use ($query) {
                $q->where('display_name', 'like', '%' . $query . '%')
                    ->orWhere('name', 'like', '%' . $query . '%')
                    ->orWhere('email', 'like', '%' . $query . '%');
            })->paginate(3);
        } else {
            $users = User::paginate(3);
        }

        return view('admin.users', compact('users'));
    }

    public function user(User $user)
    {
        return view('admin.user', compact('user'));
    }

    public function delete(User $user)
    {
        if ($user->isAdmin()) {
            return redirect()
                ->back()
                ->with('errorToast', 'Nie możesz usunąć administratora!');
        }

        if ($user->avatar) {
            Storage::delete('avatars/' . $user->avatar);
        }

        if ($user->background) {
            Storage::delete('backgrounds/' . $user->background);
        }

        $posts = $user->posts;
        foreach ($posts as $post) {
            $attachments = $post->attachments;
            foreach ($attachments as $attachment) {
                Storage::delete('public/images/attachments/' . $attachment->file_name);
                $attachment->delete();
            }
            $post->reactions()->delete();
            // $post->delete();
        }

        $user->posts()->delete();
        $user->subscriptions()->delete();
        $user->subscribedBy()->delete();

        $name = $user->name;
        $user->delete();

        return redirect()
            ->back()
            ->with('successToast', 'Użytkownik ' . $name . ' został pomyślnie usunięty!');
    }

    public function deleteAvatar(User $user)
    {
        if ($user->avatar) {
            Storage::delete('public/images/avatars/' . $user->avatar);
        }

        $user->avatar = null;
        $user->save();

        return redirect()
            ->back()
            ->with('successToast', 'Awatar tego użytkownika został usunięty!');
    }

    public function deleteBackground(User $user)
    {
        if ($user->background) {
            Storage::delete('public/images/backgrounds/' . $user->background);
        }

        $user->background = null;
        $user->save();

        return redirect()
            ->back()
            ->with('successToast', 'Zdjęcie w tle tego użytkownika zostało usunięte!');
    }

    public function updateAvatar(Request $request, User $user)
    {
        $request->validate([
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif|max:1000'
        ]);

        if ($user->avatar) {
            Storage::delete('avatars/' . $user->avatar);
        }

        $file = $request->file('avatar');
        $path = Storage::putFile('public/images/avatars', $file);
        $user->avatar = basename($path);
        $user->save();

        return redirect()
            ->back()
            ->with('successToast', 'Awatar tego użytkownika został pomyślnie zmieniony.');
    }

    public function updateBackground(Request $request, User $user)
    {
        $request->validate([
            'background' => 'required|image|mimes:jpeg,png,jpg,gif|max:1000'
        ]);

        if ($user->background) {
            Storage::delete('backgrounds/' . $user->background);
        }

        $file = $request->file('background');
        $path = Storage::putFile('public/images/backgrounds', $file);
        $user->background = basename($path);
        $user->save();

        return redirect()
            ->back()
            ->with('successToast', 'Zdjęcie w tle tego użytkownika zostało pomyślnie zmienione.');
    }

    function update(Request $request, User $user)
    {
        $validatedData = $request->validate([
            'name' => 'nullable|string|max:24|regex:/^[^\s]+$/|unique:users,name,' . $user->id,
            'display_name' => 'nullable|string|max:40',
            'new-password' => 'nullable|min:4|confirmed',
            'bio' => 'nullable|max:1000',
            'location' => 'nullable|max:64',
            'website_url' => 'nullable|max:100|active_url',
        ], [
            'name.string' => 'Nazwa użytkownika musi być ciągiem znaków.',
            'name.unique' => 'Nazwa użytkownika musi być unikalna.',
            'name.regex' => 'Nazwa użytkownika nie może zawierać spacji.',
            'display_name.string' => 'Nazwa wyświetlana musi być ciągiem znaków.',
            'display_name.max' => 'Nazwa wyświetlana nie może być dłuższa niż 40 znaków.',
            'new-password.min' => 'Nowe hasło musi mieć co najmniej 4 znaki.',
            'new-password.confirmed' => 'Potwierdzenie nowego hasła nie pasuje.',
            'bio.max' => 'Bio nie może być dłuższe niż 1000 znaków.',
            'location.max' => 'Lokalizacja nie może być dłuższa niż 64 znaki.',
            'website_url.max' => 'Adres URL strony internetowej nie może być dłuższy niż 100 znaków.',
            'website_url.active_url' => 'Adres URL strony internetowej jest nieprawidłowy.',
        ]);

        $filteredData = array_filter($validatedData, function ($value) {
            return $value !== null;
        });

        $user->update($filteredData);

        if ($request->has('new-password')) {
            $user->update(['password' => Hash::make($request->input('new-password'))]);
        }

        return to_route('admin.users.edit', $user)
            ->with('successToast', 'Użytkownik został pomyślnie zaktualizowany.');
    }
}
