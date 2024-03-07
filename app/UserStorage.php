<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserStorage extends Model
{
    protected $table ='userstorage';
    protected $fillable =['idpost','user_id'];

    public function post()
    {
    	return $this->belongsTo(Post::class,'idpost');
    }
    public function user()
    {
    	return $this->belongsTo(User::class,'user_id');
    }
}
