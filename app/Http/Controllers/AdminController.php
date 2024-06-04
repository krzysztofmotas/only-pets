<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

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

        $posts = $user->posts();

        foreach ($posts as $post) {
            $attachments = $post->attachments;
            foreach ($attachments as $attachment) {
                Storage::delete('public/images/attachments/' . $attachment->file_name);
                $attachment->delete();
            }
            $post->reactions()->delete();
        }

        $posts->delete();
        $user->subscriptions()->delete();
        $user->subscribedBy()->delete();

        $name = $user->name;
        $user->delete();

        return redirect()
            ->back()
            ->with('successToast', 'Użytkownik ' . $name . ' został pomyślnie usunięty!');
    }
}
