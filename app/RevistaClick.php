<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RevistaClick extends Model
{
    protected $table = 'revista_clicks';

    protected $fillable =['idpublicacion','user_id','user_ip'];

    public function revista()
    {
    	return $this->belongsTo(Publicacion::class,'idpublicacion');
    }
    public function user()
    {
    	return $this->belongsTo(User::class,'user_id');
    }
}
