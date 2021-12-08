<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Profile;
use App\User;
use App\Follow;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $profile = Profile::find($id);
        $user = User::find($id);
        $follow_status = follow::where('user_following_id', $id)->where('user_id', Auth::id())->first();
        $following = follow::where('user_following_id', $id)->count();
        $followers = follow::where('user_id', $id)->count();
        
        if($user){
            return view('profile.show', compact('profile', 'user', 'follow_status', 'following', 'followers'));
        } else {
            return redirect('/');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $profile = Profile::find($id);
        if ($profile->user->id == Auth::id()) {
            return view('profile.edit', compact('profile'));
        } else {
            return back();
        }
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
            'fullname' => 'required',
            'photo' => 'mimes:png,jpg,jpeg|max:2000',
            'bio' => 'required',
        ]);

        $photo = $request->file('photo');

        if ($photo == null) {
            $query = Profile::where('id', $id)
                ->update([
                    'fullname' => $request['fullname'],
                    'bio' => $request['bio'],
                ]);
        } else {
            $tujuan_upload = public_path("image\profile\\");
            $nama_photo = Auth::user()->id . "-" . Auth::user()->name . ".png";

            $photo->move($tujuan_upload, $nama_photo);

            $photo_path = "image\profile\\$nama_photo";

            $query = Profile::where('id', $id)
                ->update([
                    'fullname' => $request['fullname'],
                    'photo' => $photo_path,
                    'bio' => $request['bio'],
                ]);
        }
        Alert::success('Success', 'Update Profile Successful');
        return redirect('/profile/' . Auth::id());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();

        return redirect('/login')->withSuccess('Goodbye and Thank You!');
    }

    public function follow($id)
    {
        $follow_status = follow::where('user_following_id', $id)->where('user_id', Auth::id())->first();
        $user = User::find(Auth::id());
        if ($follow_status) {
            $user->follows()->detach($id);
        } else {
            $user->follows()->attach($id);
        }

        return redirect('/profile/' . $id);
    }
}
