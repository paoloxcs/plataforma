<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    protected $table='videos';
    protected $primaryKey='idvideo';
    protected $fillable =['idvideo','idpost','duracion','url_preview'];
    public $timestamps =false;

    public function post(){
    	return $this->belongsTo('App\Post','idpost');
    }
}
