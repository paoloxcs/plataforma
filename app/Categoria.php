<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class Categoria extends Model
{
    //Definicion de la tabla a usar y su llave primaria
    protected $table ='categoria';
    protected $primaryKey='idcategoria';
    protected $fillable =['idcategoria','idrubro','nombrecategoria','slug'];

    //Definicion de relaciones
    public function rubro(){
    	return $this->belongsTo(Rubro::class,'idrubro');
    }
    public function subcategorias(){
    	return $this->hasMany(Subcategoria::class,'idcategoria');
    }
    //evitamos que se agregue los campos created_ad y updated_ad
    //que por defecto laravel los agrega
    public $timestamps=false;

    public function countVideos()
    {
        $totalVideos = DB::table('posts as p')
        ->join('subcategoria as sc','p.idsubcategoria','=','sc.idsubcategoria')
        ->join('categoria as c','sc.idcategoria','=','c.idcategoria')
        ->where([['c.idcategoria','=',$this->idcategoria],['p.type','=','video']])->count();
        return $totalVideos;
    }
    // Is_active_capacitacion
    public function countVideosActive()
    {
        $totalVideos = DB::table('posts as p')
            ->join('subcategoria as sc', 'p.idsubcategoria', '=', 'sc.idsubcategoria')
            ->join('categoria as c', 'sc.idcategoria', '=', 'c.idcategoria')
            ->where([['c.idcategoria', '=', $this->idcategoria], ['p.type', '=', 'video'], ['p.is_active', true]])->count();
        return $totalVideos;
    }
    public function countSeries()
    {
        $totalVideos = DB::table('posts as p')
        ->join('subcategoria as sc','p.idsubcategoria','=','sc.idsubcategoria')
        ->join('categoria as c','sc.idcategoria','=','c.idcategoria')
        ->where([['c.idcategoria','=',$this->idcategoria],['p.type','=','serie']])->count();
        return $totalVideos;
    }
    public function countArticulos()
    {
        $totalArticulos = DB::table('posts as p')
        ->join('subcategoria as sc','p.idsubcategoria','=','sc.idsubcategoria')
        ->join('categoria as c','sc.idcategoria','=','c.idcategoria')
        ->where([['c.idcategoria','=',$this->idcategoria],['p.type','=','articulo']])->count();
        return $totalArticulos;
    }
}
