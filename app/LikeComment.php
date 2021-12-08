<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LikeComment extends Model
{
	protected $table = "like_comments";
	protected $fillable = ['comment_id', 'user_id'];
	protected $guarded = [];
}
