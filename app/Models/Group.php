<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $table = 'groups';
		protected $fillable = ['name', 'email', 'type', 'comment', 'token'];

		public function users()
		{
				return $this->belongsToMany('App\Models\Auser', 'a_group_user', 'group_id', 'a_user_id');
		}

}
