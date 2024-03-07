<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ComentarioCurso extends Model
{
    protected $table ='comentarios_cursos';
    protected $primaryKey = 'id';
    protected $fillable =['user_id','curso_id','texto'];

    public function user()
    {
    	return $this->belongsTo(User::class,'user_id');
    }
    public function curso()
    {
    	return $this->belongsTo(Curso::class,'id');
    }

     public function respuestas()
    {
    	return $this->hasMany(RespuestaCurso::class);
    }
}
