<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class material extends Model
{
    protected $table ='material';
    protected $primaryKey = 'id';
    protected $fillable =['nombre_documento','url_file','peso','slug','curso_id','tipo'];

    public function curso()
    {
        return $this->belongsTo(Curso::class,'curso_id');
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
