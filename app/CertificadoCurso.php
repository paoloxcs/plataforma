<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CertificadoCurso extends Model
{
    protected $table ='cursos_certificado';
    protected $fillable =['user_id','curso_id','email','fullname','phone_number','estado'];

   // public $timestamps = false;

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }


     public function curso()
    {
        return $this->belongsTo(Curso::class,'curso_id');
    }

   
}
