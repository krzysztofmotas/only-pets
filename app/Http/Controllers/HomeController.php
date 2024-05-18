<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        // $users = User::where('votes', '>', 100)->paginate(15);
        $posts = Post::orderBy('created_at', 'desc')->paginate(10);

        if ($request->ajax()) {
            return response()->json([
                'posts' => $posts,
                'next_page_url' => $posts->nextPageUrl()
            ]);
        }

        // return?
    }
}
