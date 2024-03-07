<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Respuestas_Preguntas_Curso extends Model
{	
	protected $table ='respuestas_preguntas_curso';
    protected $primaryKey = 'id';
    protected $fillable = ['valor','texto','pregunta_id','user_id'];

    public function pregunta()
    {
    	return $this->belongsTo(Preguntas_Encuestas_Curso::class,'pregunta_id');
    }
    public function user()
    {
    	return $this->belongsTo(User::class,'user_id');
    }
}
