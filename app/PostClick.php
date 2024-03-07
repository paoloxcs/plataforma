<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PostClick extends Model
{
    protected $table ='post_clicks';

    protected $fillable =['idpost','user_id','user_ip'];

    public function post()
    {
    	return $this->belongsTo(Post::class,'idpost');
    }
    public function user()
    {
    	return $this->belongsTo(User::class,'user_id');
    }
}
