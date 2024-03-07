<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Evaluacion extends Model
{
    protected $table ='evaluacion';
    protected $primaryKey = 'id';
    protected $fillable =['titulo','slug','fecha','curso_id'];

    public function curso()
    {
        return $this->belongsTo(Clase::class,'curso_id');
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
