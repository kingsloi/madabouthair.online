<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Canvas\Models\Post;

class PageController extends Controller
{
    public function index()
    {
        $latest = Post::orderBy('published_at', 'desc')
            ->where('published_at', '<=', Carbon::now())
            ->where('is_published', 1)
            ->first();

        return view('home', compact('latest','hair'));
    }

    public function contact()
    {
        return view('contact');
    }
}
