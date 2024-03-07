<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Paper extends Model
{
    protected $table ='papers';
    protected $primaryKey='idpaper';
    protected $fillable =['idpaper','idpost','pages','fechaimp'];
    public $timestamps =false;

    public function post(){
    	return $this->belongsTo('App\Post','idpost');
    }
    
}
