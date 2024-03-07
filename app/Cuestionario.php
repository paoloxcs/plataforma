<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Cuestionario extends Model
{
    protected $table ='cuestionario';
    protected $primaryKey = 'id';
    protected $fillable =['pregunta','evaluacion_id'];

    public function evaluacion()
    {
        return $this->belongsTo(Clase::class,'evaluacion_id');
    }

   /* public function docente()
    {
        return $this->belongsTo(Docente::class,'docente_id');
    }

    public function imagenes()
    {
    	$imagenes= Imagen::where('clase_id','=',$this->id)->first();
        return $imagenes;
    }
    public function vistas(){
        $vistas=CursoVista::where('clase_id','=',$this->id)->latest()->take(7)->orderby('created_at','Asc')->get();
        return $vistas;
    }
     public function imagen()
    {
        return $this->hasMany(Imagen::class);
    }*/

}
