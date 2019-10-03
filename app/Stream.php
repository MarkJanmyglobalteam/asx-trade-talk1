<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Stream extends Model
{
	protected $fillable = [
		'user_id',
		'post',
		'like',
		'attached_file'
	];
}
