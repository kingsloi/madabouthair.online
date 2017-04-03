<?php

namespace App\Http\Controllers\Frontend;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Canvas\Models\Post;
use App\Http\Controllers\Controller;

class PageController extends Controller
{
    /**
     * Show the homepage
     * @return Illuminate\View\View
     */
    public function index()
    {
        $latest = Post::orderBy('published_at', 'desc')
            // ->where('published_at', '<=', Carbon::now())
            // ->where('is_published', 1)
            ->where('id', 1)
            ->first();

        return view('home', compact('latest'));
    }

    /**
     * Show the contact page
     * @return Illuminate\View\View
     */
    public function contact()
    {
        return view('contact');
    }

    /**
     * Show the search page
     * @return Illuminate\View\View
     */
    public function search(Request $request)
    {
        $posts = [];
        $query = ($request->only('q')['q'] ?: null);

        if ($query) {
            $posts = Post::search($query)
                ->orderBy('published_at')
                ->get();
        }

        return view('search', compact('query', 'posts'));
    }
}
