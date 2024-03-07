<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Preguntas_Encuestas_Curso extends Model
{	
	protected $table ='preguntas_encuestas_curso';
    protected $primaryKey = 'id';
    protected $fillable = ['pregunta', 'descripcion','encuesta_id','tipo_respuesta'];

    public function encuesta()
    {
    	return $this->belongsTo(Encuestas_Curso::class,'encuesta_id');
    }
}
