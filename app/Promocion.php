<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Promocion extends Model
{
    protected $table ='promociones';
    protected $fillable = ['name','slug','descripcion','url_portada','precio','fecha_ini','fecha_fin','plan_id','estado'];

    public function plan()
    {
    	return $this->belongsTo(Plan::class,'plan_id');
    }

}
