<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;

class PostController extends Controller
{
    use AuthorizesRequests;

    public function store(StorePostRequest $request)
    {
        // $this->authorize('store');
        $hasAttachments = $request->has('attachments');

        $rules = [
            'attachments.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'text' => $hasAttachments ? '' : 'required|' . 'string|max:255',
        ];

        $messages = [
            'attachments.*.max' => 'Załącznik nr :index nie może być większy niż :max kilobajtów.',
            'attachments.*.mimes' => 'Załącznik nr :index musi być plikiem typu: :values.',
            'attachments.*.image' => 'Załącznik nr :index musi być obrazem.',
            'text.required' => 'Treść wiadomości jest wymagana, jeśli nie dodano żadnych załączników.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $user = Auth::user();

        /** @var \App\Models\User $user **/
        $post = $user->posts()->create([
            'text' => $request->input('text'),
        ]);

        if ($hasAttachments) {
            foreach ($request->attachments as $file) {
                $path = Storage::putFile('public/images/attachments', $file);

                $attachment = $post->attachments()->create([
                    'file_name' => basename($path),
                ]);

                Log::info('Stworzono nowy załącznik', ['post_id' => $post->id, 'attachment_id' => $attachment->id, 'file_path' => $path]);
            }
        }

        Log::info('Stworzono nowy post', ['post_id' => $post->id, 'user_id' => $user->id]);

        Session::put('successToast' , 'Twój post został pomyślnie dodany!');
        return response()->noContent();
    }

    public function edit(Post $post)
    {
        $this->authorize('update', $post);

        // return view('home.edit-post', compact());
    }

    public function update(UpdatePostRequest $request, Post $post)
    {
       //  $this->authorize('update', $post);
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

        return redirect()
            ->back()
            ->with('successToast', 'Wybrany post został pomyślnie usunięty.');
    }
}
