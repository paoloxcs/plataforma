<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Asignacion extends Model
{
    protected $table = 'asignaciones';
    protected $fillable =['suscriptor_id','gestor_id','is_confirmed'];

    public function suscriptor()
    {
    	return $this->belongsTo(User::class,'suscriptor_id');
    }
    public function gestor()
    {
    	return $this->belongsTo(User::class,'gestor_id');
    }
}
