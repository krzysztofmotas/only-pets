<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Log;

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

        $suggestedUsers = User::getSuggestedUsers();
        return view('home.index', compact('suggestedUsers'));
    }

    public function search(Request $request)
    {
        $query = $request->input('query');

        $users = User::where(function ($q) use ($query) {
            $q->where('display_name', 'like', '%' . $query . '%')
                ->orWhere('name', 'like', '%' . $query . '%');
        })->take(10)->get();

        $suggestedUsers = User::getSuggestedUsers();
        return view('home.search', compact('users', 'suggestedUsers'));
    }

    public function profile(User $user) {
        $suggestedUsers = User::getSuggestedUsers();

        $postsCount = $user->posts()->count();
        $attachmentsCount = $user->posts()->withCount('attachments')->get()->pluck('attachments_count')->sum();

        $daysSinceRegistration = $user->created_at->diffInRealDays(now());
        $averagePostsPerDay = $daysSinceRegistration > 1.0 ? $postsCount / $daysSinceRegistration : $postsCount;

        return view('home.profile', compact(
            'user',
            'suggestedUsers',
            'postsCount',
            'attachmentsCount',
            'averagePostsPerDay'));
    }
}
