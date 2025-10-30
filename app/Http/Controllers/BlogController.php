<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index()
    {
        $posts = Post::with('user')->where('status', 'published')->latest()->paginate(10);
        return view('blog.index', compact('posts'));
    }

    public function show(Post $post)
    {
        // Assurer que seuls les articles publiés sont accessibles directement
        if ($post->status !== 'published') {
            abort(404);
        }
        return view('blog.show', compact('post'));
    }
}
