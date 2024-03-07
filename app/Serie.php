<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Serie extends Model
{
    protected $table='series';
    protected $primaryKey='idserie';
    protected $fillable =['idserie','idpost','duracion','url_preview'];
    public $timestamps =false;

    public function post(){
    	return $this->belongsTo('App\Post','idpost');
    }
}
