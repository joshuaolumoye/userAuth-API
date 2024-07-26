<?php

namespace App\Http\Controllers;

use App\Models\Post;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Request;
use Illuminate\Contracts\Auth\Access\Gate;

class PostController extends Controller implements HasMiddleware
{
    public static functionmiddleware(){
        return[
            new Middleware('auth:sanctum', except:['index', 'show']);
        ]
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Post::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $fields = $request->validate([
                'title' => 'required|max:255',
                'body' => 'required'
            ]);

            $post = $request->user()->post()->create($fields);

            return $post;
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        return $post;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
    
        Gate::authorise('modify', $post);
        $fields = $request->validate([
            'title' => 'required|max:255',
            'body' => 'required'
        ]);

        $post->update($fields) ;

        return $post;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        Gate::authorise('modify', $post);
        $post->delete();
        return ['message' => 'this was deleated']
    }
}
