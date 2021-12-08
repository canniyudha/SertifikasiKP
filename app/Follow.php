<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Follow extends Model
{
	protected $table = "follows";
	protected $fillable = ['user_following_id', 'user_id'];
	protected $guarded = [];
	public $timestamps = false;
}
