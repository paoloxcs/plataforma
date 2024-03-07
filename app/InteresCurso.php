<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InteresCurso extends Model
{
    protected $table = 'cursos_interes';
    protected $primaryKey = 'id';
    protected $fillable =['curso_id','user_id'];

    public function curso()
    {
    	return $this->balongsTo(Curso::class,'curso_id');
    }
    public function user()
    {
    	return $this->belongsTo(User::class,'user_id');
    }

    
}
