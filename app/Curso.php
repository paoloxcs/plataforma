<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Curso extends Model
{
    protected $table ='cursos';
    protected $primaryKey = 'id';
    protected $fillable =['titulo','descripcion','objetivos','publico','informacion','urlportada','precio','promocion','precio_d','promocion_d','precio_c','promocion_c','estado','fecha','time','slug','rubro_id','autor_id','banner_portada','banner_descripcion','expira','fecha_culminacion','beneficios'];

    public function rubro()
    {
        return $this->belongsTo(Rubro::class,'rubro_id');
    }

    public function autor()
    {
        return $this->belongsTo(Autor::class,'autor_id');
    } 


    public function countClases()
    {
         $totalclases = DB::table('clases as c')
        ->where('c.curso_id','=',$this->id)->count();
        return $totalclases;
    }

    public function countAlumnos()
    {
         $totalalumnos = DB::table('suscriptores_cursos as s')
        ->where('s.curso_id','=',$this->id)->count();
        return $totalalumnos;
    }

     public function CountValoracion()
    {
        $countvaloracion = DB::table('cursos_valoraciones as c')
        ->where('c.curso_id','=',$this->id)->count();
        return $countvaloracion;
    }

      
    public function vistas(){
         return $this->hasOne(Cursovista::class,'id');
    }

       public function Sponsors()
    {
        $sponsors = DB::table('cursos_sponsors as c')
        ->where('c.curso_id','=',$this->id)->count();
        return $sponsors;
    }
    
    
       public function sponsor()
    {
        $sponsors = DB::table('cursos_sponsors as c')
        ->where('c.curso_id','=',$this->id)->get();
        return $sponsors;
    }

       public function encuestas()
    {
        $encuestas = DB::table('encuestas_curso as c')
        ->where('c.curso_id','=',$this->id)->count();
        return $encuestas;
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
