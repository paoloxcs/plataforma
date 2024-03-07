<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Encuestas_Curso extends Model
{	
	protected $table ='encuestas_curso';
    protected $primaryKey = 'id';
    protected $fillable = ['titulo', 'descripcion','curso_id'];

    public function curso()
    {
    	return $this->belongsTo(Curso::class,'curso_id');
    }
}
