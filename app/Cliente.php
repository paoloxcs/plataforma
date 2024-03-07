<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $fillable =['empresa','user_id','status','medio','fecha_registro','fecha_caducidad'];

    public $timestamps = false;

    public function user()
    {
    	return $this->belongsTo(User::class,'user_id');
    }

    public function ejecutivo()
    {
    	return $this->belongsToMany(Ejecutivo::class,'clientes_ejecutivos','cliente_id','ejecutivo_id');
    }
    public function getEstado()
    {
        if($this->status ==1) return "Activo";
        return "Inactivo";
    }

     public function Caducidad()
    {
        $hoy = date_create(date('Y-m-d'));
        $lastDate = date_create($this->fecha_caducidad);
        $interval  = date_diff($hoy,$lastDate);
        $numDays = $interval->format('%R%a');
        if ($numDays < 0) {
            return 0;
        }else{
            return $interval->format('%a');
        }
    }
    


}
