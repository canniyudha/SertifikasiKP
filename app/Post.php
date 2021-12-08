<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
	protected $table = "posts";
	protected $guarded = [];

	public function user()
	{
		return $this->belongsTo('App\User', 'user_id');
	}

	public function comments()
	{
		return $this->hasMany('App\Comment', 'post_id');
	}

	public function like_posts()
	{
		return $this->belongsToMany('App\User', 'like_posts', 'post_id', 'user_id');
	}
}
