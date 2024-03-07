<?php

namespace App;

use DB;
use Illuminate\Database\Eloquent\Model;

class Rubro extends Model
{
	//definiendo la tabla a usar y su llave primaria
    protected $table ='rubro';
    protected $primaryKey='idrubro';

   //campos que podran ser mostrados en la vista
    protected $fillable =['idrubro','nombrerubro','slug','estado','img_curso','img_capacitacion','img_revista','img_articulo','img_suplemento','img_beneficio'];

    //Definicion de relacion con el modelo Categoria
    public function categorias(){
        return $this->hasMany(Categoria::class,'idrubro');
    }

    public function sliders(){
        return $this->hasMany(Slider_Rubro::class,'rubro_id');
    }

    //evitamos que se agregue los campos created_ad y updated_ad
    //que por defecto laravel los agrega
    public $timestamps=false;

    public function videos($limit)
    { 
        // $videos = DB::table('posts as p')
        //     ->join('subcategoria as sc', 'p.idsubcategoria', '=', 'sc.idsubcategoria')
        //     ->join('categoria as c', 'sc.idcategoria', '=', 'c.idcategoria')
        //     ->join('rubro as r', 'c.idrubro', '=', 'r.idrubro')
        //     ->join('autor as au', 'au.idautor', '=', 'p.idautor')
        //     ->where([['r.idrubro', '=', $this->idrubro], ['p.type', '=', 'video']])
        //     ->select('p.titulo', 'p.slug as pslug', 'p.image', 'au.nombre as nombreautor', 'au.slug as auslug')
        //     ->orderBy('p.idpost', 'desc')->limit($limit)->get();

        $videos = DB::table('posts as p')
            ->join('subcategoria as sc', 'p.idsubcategoria', '=', 'sc.idsubcategoria')
            ->join('categoria as c', 'sc.idcategoria', '=', 'c.idcategoria')
            ->join('rubro as r', 'c.idrubro', '=', 'r.idrubro')
            ->join('autor as au', 'au.idautor', '=', 'p.idautor')
            ->where([['r.idrubro', '=', $this->idrubro], ['p.type', '=', 'video'], ['p.is_active', true]])
            ->select('p.titulo', 'p.slug as pslug', 'p.image', 'au.nombre as nombreautor', 'au.slug as auslug')
            ->orderBy('p.idpost', 'desc')->limit($limit)->get();

        return $videos;
    }


    public function countVideos()
    {
        $totalVideos = DB::table('posts as p')
        ->join('subcategoria as sc','p.idsubcategoria','=','sc.idsubcategoria')
        ->join('categoria as c','sc.idcategoria','=','c.idcategoria')
        ->join('rubro as r','c.idrubro','=','r.idrubro')
        ->where([['r.idrubro','=',$this->idrubro],['p.type','=','video']])->count();

        return $totalVideos;
    }
        public function countSeries()
    {
        $totalVideos = DB::table('posts as p')
        ->join('subcategoria as sc','p.idsubcategoria','=','sc.idsubcategoria')
        ->join('categoria as c','sc.idcategoria','=','c.idcategoria')
        ->join('rubro as r','c.idrubro','=','r.idrubro')
        ->where([['r.idrubro','=',$this->idrubro],['p.type','=','serie']])->count();

        return $totalVideos;
    }
    public function countArticulos()
    {
        $totalArticulos = DB::table('posts as p')
        ->join('subcategoria as sc','p.idsubcategoria','=','sc.idsubcategoria')
        ->join('categoria as c','sc.idcategoria','=','c.idcategoria')
        ->join('rubro as r','c.idrubro','=','r.idrubro')
        ->where([['r.idrubro','=',$this->idrubro],['p.type','=','articulo']])->count();

        return $totalArticulos;
    }
    public function events()
    {
        return $this->hasMany(Event::class, 'rubro_id', 'idrubro');
    }

    

}
