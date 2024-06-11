<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $posts = Post::with([
                'user:id,name,display_name,avatar',
                'attachments:post_id,file_name'
            ])->orderBy('created_at', 'desc')->paginate(10);

            /** @var \App\Models\User $user **/
            $user = Auth::user();
            $posts = self::processPosts($posts, $user);

            return response()->json([
                'posts' => $posts,
                'next_page_url' => $posts->nextPageUrl()
            ]);
        }

        $suggestedUsers = User::getSuggestedUsers();
        return view('home.index', compact('suggestedUsers'));
    }

    public function ranks()
    {
        return view('home.ranks');
    }

    public function search(Request $request, $nav = false)
    {
        if ($nav) {
            return view('home.search', compact('nav'));
        }

        $query = $request->input('query');

        $users = User::where(function ($q) use ($query) {
            $q->where('display_name', 'like', '%' . $query . '%')
                ->orWhere('name', 'like', '%' . $query . '%');
        })->take(10)->get();

        $suggestedUsers = User::getSuggestedUsers();
        return view('home.search', compact('users', 'suggestedUsers', 'nav'));
    }

    public function profile(Request $request, User $user)
    {
        if ($request->ajax()) {
            $posts = $user->posts()->with([
                'user:id,name,display_name,avatar',
                'attachments:post_id,file_name'
            ])->orderBy('created_at', 'desc')->paginate(10);

            /** @var \App\Models\User $user **/
            $user = Auth::user();
            $posts = self::processPosts($posts, $user);

            return response()->json([
                'posts' => $posts,
                'next_page_url' => $posts->nextPageUrl()
            ]);
        }

        $suggestedUsers = User::getSuggestedUsers();

        $postsCount = $user->posts()->count();
        $attachmentsCount = $user->posts()->withCount('attachments')->get()->pluck('attachments_count')->sum();

        $daysSinceRegistration = $user->created_at->diffInRealDays(now());
        $averagePostsPerDay = $daysSinceRegistration > 1.0 ? $postsCount / $daysSinceRegistration : $postsCount;

        $subscriptions = $user->subscribedBy()->with(['subscriber:id,name,display_name,avatar'])->where('end_at', '>', now())->get();

        return view('home.profile', compact(
            'user',
            'suggestedUsers',
            'postsCount',
            'attachmentsCount',
            'averagePostsPerDay',
            'subscriptions'
        ));
    }

    private static function processPosts($posts, $user = null)
    {
        $posts->transform(function ($post) use ($user) {
            if ($user) {
                $post->is_subscribed = ($user->id == $post->user->id || $user->isAdmin())
                ? true : $user->hasActiveSubscriptionFor($post->user_id);
            } else {
                $post->is_subscribed = false;
            }

            if (!$post->is_subscribed) {
                unset($post->text);
                unset($post->attachments);
            }

            return $post;
        });

        return $posts;
    }

    public function getNotifications(Request $request)
    {
        /** @var \App\Models\User $user **/
        $user = Auth::user();
        $oneWeekFromNow = Carbon::now()->addWeek();

        $notifications = $user->subscriptions()
            ->with(['subscribedUser:id,name'])
            ->where('show_notification', true)
            ->where('end_at', '<=', $oneWeekFromNow)
            ->get();

        return response()->json($notifications);
    }

    public function clearNotifications()
    {
        /** @var \App\Models\User $user **/
        $user = Auth::user();
        $oneWeekFromNow = Carbon::now()->addWeek();

        $user->subscriptions()
            ->where('show_notification', true)
            ->where('end_at', '<=', $oneWeekFromNow)
            ->update([
                'show_notification' => false
            ]);

        return redirect()
            ->back()
            ->with('successToast', 'Powiadomienia zostały wyczyszczone.');
    }
}
