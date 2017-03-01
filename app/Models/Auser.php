<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Auser extends Model
{
		protected $table = 'a_users';
		protected $fillable = ['name', 'email', 'weixin', 'comment'];

		public function groups()
		{
				return $this->belongsToMany('App\Models\Group', 'a_group_user', 'a_user_id', 'group_id');
		}
}
