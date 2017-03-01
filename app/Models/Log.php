<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    protected $fillable = ['hostname', 'ip', 'token', 'content'];

    public function group()
    {
    		return $this->belongsTo('App\Models\Group', 'token', 'token');
    }
}
