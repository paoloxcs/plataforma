<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class Autor extends Model
{
    protected $table ='autor';
    protected $primaryKey='idautor';
    protected $fillable =['idautor','nombre','bio','nacionalidad','imagen','cargo','principal'];
    public $timestamps =false;

    public function posts(){
    	return $this->hasMany(Post::class,'idautor');
    }

    public function curso(){
    	return $this->hasMany(Curso::class,'autor_id');
    }
    

    public function cursoR(){
    	$rubro = DB::table('cursos as c')
        ->where('c.autor_id','=',$this->idautor)->join('rubro as r','r.idrubro','=','c.rubro_id')->get();
        return $rubro;
    }
    

}
