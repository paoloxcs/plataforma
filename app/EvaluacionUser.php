<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class EvaluacionUser extends Model
{
    protected $table ='evaluacion_users';
    protected $primaryKey = 'id';
    protected $fillable =['respuesta1','respuesta2','respuesta3','respuesta4','respuesta5','respuesta6','respuesta7','respuesta8','respuesta9','respuesta10','total_buenas','total_malas','evaluacion_id','user_id'];

    public function evaluacion()
    {
        return $this->belongsTo(Evaluacion::class,'evaluacion_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
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
