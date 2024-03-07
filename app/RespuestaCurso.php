<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RespuestaCurso extends Model
{
	protected $table ='respuestas_cursos';
    protected $primaryKey = 'id';
    protected $fillable =['comentario_id','user_id','texto'];

    public function user()
    {
    	return $this->belongsTo(User::class,'user_id');
    }
    public function comentario()
    {
    	return $this->belongsTo(ComentarioCurso::class,'comentario_id');
    }
}
