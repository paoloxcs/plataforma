<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comentario extends Model
{
    protected $fillable =['user_id','idpost','texto'];

    public function user()
    {
    	return $this->belongsTo(User::class,'user_id');
    }
    public function post()
    {
    	return $this->belongsTo(Post::class,'idpost');
    }

    public function respuestas()
    {
    	return $this->hasMany(Respuesta::class);
    }
}
