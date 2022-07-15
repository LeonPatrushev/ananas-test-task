<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::paginate(20);
        return response()->json([
            'data' => $posts
        ], 200);
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'content'=> 'required'
        ]);

        $post = new Post();
        $post->content = $request->content;
        if (auth()->user()->posts()->save($post))
        {
            return response()->json([
                'success' => true,
            ], 200);
        }
        else
        {
            return response()->json([
                'error' => 'Post not added'
            ], 401);
        }
    }

    public function destroy($id)
    {
        $post = auth()->user()->posts()->find($id);

        if(!$post)
        {
            return response()->json([
                'error' => 'Post not found'
            ], 404);
        }
        if($post->where('created_at', '>', Carbon::now()->subDay())->delete())
        {
            return response()->json([
                'success' => true
            ], 200);
        }
        else
        {
            return response()->json([
                'error' => 'Post can not be deleted'
            ], 401);
        }
    }
}
