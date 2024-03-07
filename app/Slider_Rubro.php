<?php

namespace App;

use DB;
use Illuminate\Database\Eloquent\Model;

class Slider_Rubro extends Model
{
	//definiendo la tabla a usar y su llave primaria
    protected $table ='slider_rubro';
    protected $primaryKey='id';
    
    protected $fillable =['rubro_id','nombrerubro','slug','estado','img_curso','img_capacitacion','img_revista','img_articulo','img_suplemento','img_beneficio','url'];

   
    //Definicion de relaciones
    public function rubro(){
    	return $this->belongsTo(Rubro::class,'rubro_id');
    }
    

}
