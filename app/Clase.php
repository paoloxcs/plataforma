<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Clase extends Model
{
    protected $table ='clases';
    protected $primaryKey = 'id';
    protected $fillable =['titulo','zoom_codigo_url','video_codigo','informacion','estado','expira','time','slug','curso_id','url_portada'];

    public function curso()
    {
        return $this->belongsTo(Curso::class,'curso_id');
    }

     public function countMaterial()
    {
         $totalmaterial = DB::table('material as m')
        ->where('m.curso_id','=',$this->id)->count();
        return $totalmaterial;
    }


   /* public function docente()
    {
        return $this->belongsTo(Docente::class,'docente_id');
    }

    public function imagenes()
    {
        $imagenes= Imagen::where('curso_id','=',$this->id)->first();
        return $imagenes;
    }
    public function vistas(){
        $vistas=CursoVista::where('curso_id','=',$this->id)->latest()->take(7)->orderby('created_at','Asc')->get();
        return $vistas;
    }
     public function imagen()
    {
        return $this->hasMany(Imagen::class);
    }*/

}
