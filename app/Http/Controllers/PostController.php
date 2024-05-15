<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function store(StorePostRequest $request)
    {
        $post = new Post();
        $user = Auth::user();

        $post->user_id = $user->id;
        $post->text = $request->input('text');
        $post->save();

        return redirect('');
    }

    public function edit(Post $post)
    {

    }

    public function update(UpdatePostRequest $request, Post $post)
    {

    }

    public function destroy(Post $post)
    {

    }
}
