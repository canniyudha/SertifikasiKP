<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
use App\Post;
use App\LikePost;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::orderBy('id', 'desc')->get();

        return view('post.index', compact('posts'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'post' => 'required',
        ]);

        $user = Auth::user();
        $post = $user->posts()->create([
            'text' => $request['post'],
        ]);

        Alert::success('Success', 'Upload Post Successful');
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::find($id);

        return view('post.detail', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'post' => 'required',
        ]);

        $post = Post::find($id);
        $post->text = $request['post'];
        $post->save();

        Alert::success('Success', 'Update Post Successful');
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::find($id);
        $post->delete();

        Alert::success('Success', 'Delete Post Successful');
        return back();
    }

    public function like($id)
    {
        $post = Post::find($id);
        $like_post_status = LikePost::where('post_id', $id)->where('user_id', Auth::id())->first();

        if ($like_post_status) {
            $post->like_posts()->detach(Auth::id());
        } else {
            $post->like_posts()->attach(Auth::id());
        }
        return back();
    }
}
