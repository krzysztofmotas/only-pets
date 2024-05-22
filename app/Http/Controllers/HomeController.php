<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Models\User;

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

    public function search(Request $request)
    {
        $query = $request->input('query');
        $users = User::where('display_name', 'like', '%' . $query . '%')
                    ->where('name', 'like', '%' . $query . '%')
                    ->take(10)
                    ->get();

        return view('home.search', compact('users'));
    }
}
