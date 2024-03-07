<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Publicacion extends Model
{
    protected $table ='publicaciones';
    protected $primaryKey ='idpublicacion';

   /* protected $fillable =[''];*/

    public $timestamps = false;

    public function clicks()
    {
    	return $this->hasMany(RevistaClick::class,'idpublicacion');
    }
}
