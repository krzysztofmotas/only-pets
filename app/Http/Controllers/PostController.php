<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\PostAttachment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;

class PostController extends Controller
{
    use AuthorizesRequests;

    public function store(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(null, 403);
        }

        $hasAttachments = $request->has('attachments');

        $rules = [
            'attachments' => 'array|max:' . env('MAX_POST_ATTACHMENTS'),
            'attachments.*' => 'image|mimes:jpeg,png,jpg,gif|max:2097152', // 2mb
            'text' => $hasAttachments ? '' : 'required|' . 'string|max:255',
        ];


        /** @var \App\Models\User $user **/
        $user = Auth::user();

        $messages = [
            'attachments.max' => 'Możesz dodać maksymalnie ' . $user->getRank()->getMaxPostAttachments() . ' załączników.',
            'attachments.*.max' => 'Załącznik nr :index nie może być większy niż :max kilobajtów.',
            'attachments.*.mimes' => 'Załącznik nr :index musi być plikiem typu: :values.',
            'attachments.*.image' => 'Załącznik nr :index musi być obrazem.',
            'text.required' => 'Treść posta jest wymagana, jeśli nie dodano żadnych załączników.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

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

        Session::put('successToast', 'Twój post został pomyślnie dodany!');
        return response()->noContent();
    }

    public function edit(Post $post)
    {
        $this->authorize('update', $post);
        return view('home.edit-post', compact('post'));
    }

    public function update(Request $request, Post $post)
    {
        $this->authorize('update', $post);

        $hasAttachments = $post->attachments()->exists();

        $request->validate(
            ['text' => $hasAttachments ? '' : 'required|' . 'string|max:255'],
            ['text.required' => 'Treść posta jest wymagana, jeśli post nie posiada żadnych załączników.']
        );

        $text = $request->input('text');

        if ($post->text == $text) {
            return redirect()
                ->back()
                ->withErrors(['text' => 'Nowa treść posta musi się różnić od starej.']);
        }
        $post->text = $text;
        $post->save();

        return to_route('home')->with('successToast', 'Treść tego posta została zaaktualizowana!');
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

    public function deleteAttachment(PostAttachment $attachment)
    {
        /** @var \App\Models\Post $post **/
        $post = $attachment->post;

        $this->authorize('update', $post);

        Storage::delete('public/images/attachments/' . $attachment->file_name);
        $attachment->delete();

        if (!$post->text && $post->attachments->count() == 0) {
            $post->reactions()->delete();
            $post->delete();

            return to_route('home')
                ->with('successToast', 'Pomyślnie usunąłeś ostatni załącznik z tego posta, a sam post został również usunięty, ponieważ nie zawierał już żadnych treści.');
        } else {
            $post->touch();

            return redirect()
                ->back()
                ->with('successToast', 'Pomyślnie usunąłeś załącznik z tego posta.');
        }
    }
}
