<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Respuesta extends Model
{
    protected $fillable =['comentario_id','user_id','texto'];

    public function user()
    {
    	return $this->belongsTo(User::class,'user_id');
    }
    public function comentario()
    {
    	return $this->belongsTo(Comentario::class,'comentario_id');
    }
}
