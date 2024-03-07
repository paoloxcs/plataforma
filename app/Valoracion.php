<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Valoracion extends Model
{
    protected $table = 'valoraciones';

    protected $fillable =['idpost','user_id'];

    public function post()
    {
    	return $this->balongsTo(Post::class,'idpost');
    }
    public function user()
    {
    	return $this->belongsTo(User::class,'user_id');
    }
}
