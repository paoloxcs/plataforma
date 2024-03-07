<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    protected $fillable = ['user_id','body'];

    public function user()
    {
    	return $this->belongsTo(User::class, 'user_id');
    }
}
