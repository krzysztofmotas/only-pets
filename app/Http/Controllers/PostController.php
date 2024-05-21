<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class PostController extends Controller
{
    use AuthorizesRequests;

    public function store(StorePostRequest $request)
    {
        // $this->authorize('store');

        // TODO
        // $request->validate([
        //     'files.*' => 'image|mimes:jpeg,png,jpg,gif', // |max:2048
        // ]);
        $user = Auth::user();

        /** @var \App\Models\User $user **/
        $post = $user->posts()->create([
            'text' => $request->input('text'),
        ]);

        if ($request->has('attachments')) {
            foreach ($request->attachments as $file) {
                $path = Storage::putFile('public/images/attachments', $file);

                $attachment = $post->attachments()->create([
                    'file_name' => basename($path),
                ]);

                Log::info('Stworzono nowy załącznik', ['post_id' => $post->id, 'attachment_id' => $attachment->id, 'file_path' => $path]);
            }
        }

        Log::info('Stworzono nowy post', ['post_id' => $post->id, 'user_id' => $user->id]);

        // return redirect()->back()
        //     ->with('successToast', 'Twój nowy post został pomyślnie dodany!');
    }

    public function edit(Post $post)
    {
        $this->authorize('update', $post);
    }

    public function update(UpdatePostRequest $request, Post $post)
    {
        $this->authorize('update', $post);
    }

    public function destroy(Post $post)
    {
        $this->authorize('destroy', $post);

        $attachments = $post->attachments;
        foreach ($attachments as $attachment) {
            Storage::delete('public/images/attachments/' . $attachment->file_name);
            $attachment->delete();
        }
        $post->reactions()->delete();
        $post->delete();

        return redirect()->back()
            ->with('successToast', 'Wybrany post został pomyślnie usunięty.');
    }
}
