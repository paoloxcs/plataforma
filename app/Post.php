<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class Post extends Model
{
    protected $table='posts';
    protected $primaryKey='idpost';
    protected $fillable = [
        'type', 'titulo', 'slug', 'infoadd', 'idautor', 'ruta',
        'fecha', 'idsubcategoria', 'image', 'idioma', 'acceso', 'is_active'
    ];
    public $timestamps =false;

    public function subcategoria(){
    	return $this->belongsTo(Subcategoria::class,'idsubcategoria');
    }
    public function autor(){
        return $this->belongsTo(Autor::class,'idautor');
    }
    public function video(){
        return $this->hasOne(Video::class,'idpost');
    }
    public function serie(){
        return $this->hasOne(Serie::class,'idpost');
    }
    public function paper(){
    	return $this->hasOne(Paper::class,'idpost');
    }
    public function valoraciones()
    {
        return $this->hasMany(Valoracion::class,'idpost');
    }
    public function comentarios()
    {
        return $this->hasMany(Comentario::class,'idpost');
    }
    public function marcados()
    {
        return $this->hasMany(UserStorage::class,'idpost');
    }
    public function clicks()
    {
        return $this->hasMany(PostClick::class,'idpost');
    }
    public function downloads()
    {
        return $this->hasMany(Download::class,'idpost');
    }

    public function limitTitulo($length = 50)
    {
        $limitTitu = "";
        if (strlen($this->titulo) > $length) {
            $limitTitu = substr($this->titulo, 0,$length).' ...';
        }else{
            $limitTitu = $this->titulo;
        }
        
        return $limitTitu;
    }
    //funcion para comprobar si el post es nuevo
    public function isNew()
    {
        $interval = date_diff(date_create($this->fecha),date_create());
        $numDays = $interval->format('%R%a');
        if($numDays < 15) return true;
        
        return false;
    }

     public function CountValoracion()
    {
        $countvaloracion = DB::table('valoraciones as v')
        ->where('v.idpost','=',$this->idpost)->count();
        return $countvaloracion;
    }

    public function CountVistas()
    {
        $countvista = DB::table('post_clicks as c')
        ->where('c.idpost','=',$this->idpost)->count();
        return $countvista;
    }

    public function vistas()
    {
        return $this->hasOne(PostClick::class,'idpost');
    }



}
