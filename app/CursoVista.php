<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\CursoVista;
use DB;

class CursoVista extends Model
{
    protected $table ='curso_vistas';
    protected $fillable =['curso_id','cant_visto'];



    public function curso()
    {
        return $this->belongsTo('App\Curso','curso_id');
    }

    public function vistas()
    {
        return $this->hasMany('App\CursoVista','curso_id');
    }
   /*  public function total_vistas($curso_id)
    {
        $total_vistas=CursoVista::first()->distinct('curso_id');
        return $total_vistas;
    }*/

    public function total_vistas()
    {
        $total_vistas=DB::table('cursos_vistas')->where('curso_id', '=', $this->curso_id)->sum('cant_visto');
        return $total_vistas;
    }
}
