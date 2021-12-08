<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
	protected $table = "comments";
	protected $fillable = ['text', 'post_id', 'user_id'];
	protected $guarded = [];

	public function user()
	{
		return $this->belongsTo('App\User', 'user_id');
	}

	public function post()
	{
		return $this->belongsTo('App\Post', 'post_id');
	}

	public function like_comments()
	{
		return $this->belongsToMany('App\User', 'like_comments', 'comment_id', 'user_id');
	}
}
