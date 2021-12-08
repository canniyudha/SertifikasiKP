<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LikePost extends Model
{
	protected $table = "like_posts";
	protected $fillable = ['post_id', 'user_id'];
	protected $guarded = [];
}
