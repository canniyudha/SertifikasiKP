<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\LikeComment;
use App\comment;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class CommentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create(Request $request, $post_id)
    {
        $request->validate([
            "comment" => "required"
        ]);

        $user = Auth::id();
        $comment = comment::create([
            "text" => $request["comment"],
            "user_id" => $user,
            "post_id" => $post_id
        ]);

        return back();
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
        $request->validate([
            "comment" => "required"
        ]);

        $update = comment::where('id', $id)->update([
            "text" => $request["comment"],
        ]);

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
        comment::destroy($id);
        Alert::success('Success', 'Delete Comment Successful');
        return back();
    }

    public function like($id)
    {
        $comment = comment::find($id);
        $like_comment_status = LikeComment::where('comment_id', $id)->where('user_id', Auth::id())->first();

        if ($like_comment_status) {
            $comment->like_comments()->detach(Auth::id());
        } else {
            $comment->like_comments()->attach(Auth::id());
        }
        return back();
    }
}
