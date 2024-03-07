<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SuscriptorOnline extends Model
{
	protected $table = 'suscriptores_online';
    protected $fillable =['solicitud_code','confirmation_code','user_id','status'];

    public function user()
    {
    	return $this->belongsTo(User::class,'user_id');
    }
}
