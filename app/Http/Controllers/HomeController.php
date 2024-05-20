<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Reaction;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $posts = Post::with([
                'user:id,name,display_name,avatar',
                'attachments:post_id,file_name'
            ])->orderBy('created_at', 'desc')->paginate(10);

            return response()->json([
                'posts' => $posts,
                'next_page_url' => $posts->nextPageUrl()
            ]);
        }

        return view('home.index');
    }
}
