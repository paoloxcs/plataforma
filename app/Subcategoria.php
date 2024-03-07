<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class Subcategoria extends Model
{
    protected $table='subcategoria';
    protected $primaryKey='idsubcategoria';
    protected $fillable =['idcategoria','nombresubcategoria','slug'];

    public function categoria(){
    	return $this->belongsTo(Categoria::class,'idcategoria');
    }
    public function posts(){
    	return $this->hasMany(Post::class,'idsubcategoria');
    }
    //evitamos que se agregue los campos created_ad y updated_ad
    //que por defecto laravel los agrega
    public $timestamps=false;

    public function countVideos()
    {
        $totalVideos = DB::table('posts as p')
        ->join('subcategoria as sc','p.idsubcategoria','=','sc.idsubcategoria')
        ->where([['sc.idsubcategoria','=',$this->idsubcategoria],['p.type','=','video']])->count();
        return $totalVideos;
    }
    
    // Is_active_capacitacion
    public function countVideosActive()
    {
        $totalVideos = DB::table('posts as p')
            ->join('subcategoria as sc', 'p.idsubcategoria', '=', 'sc.idsubcategoria')
            ->where([['sc.idsubcategoria', '=', $this->idsubcategoria], ['p.type', '=', 'video'], ['p.is_active', true]])->count();
        return $totalVideos;
    }
    public function countSeries()
    {
        $totalVideos = DB::table('posts as p')
        ->join('subcategoria as sc','p.idsubcategoria','=','sc.idsubcategoria')
        ->where([['sc.idsubcategoria','=',$this->idsubcategoria],['p.type','=','serie']])->count();
        return $totalVideos;
    }
    public function countArticulos()
    {
        $totalArticulos = DB::table('posts as p')
        ->join('subcategoria as sc','p.idsubcategoria','=','sc.idsubcategoria')
        ->where([['sc.idsubcategoria','=',$this->idsubcategoria],['p.type','=','articulo']])->count();
        return $totalArticulos;
    }

}
