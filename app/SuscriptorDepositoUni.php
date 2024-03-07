<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SuscriptorDepositoUni extends Model
{
    protected $table ='suscriptores_deposito_uni';
    protected $fillable =['user_id','plan_id','suscription_init','suscription_end','medio','tipo','metodopago_id','token','id_culqi','gestor_id'];

    public $timestamps = false;

    public function gestor()
    {
        return $this->belongsTo(User::class,'gestor_id');
    }

     public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function metodoPago()
    {
        return $this->belongsTo(MetodoPago::class,'metodopago_id');
    }

    public function pagos()
    {
        return $this->hasMany(PagoUni::class,'suscriptor_id');
    }

    public function plan()
    {
        return $this->belongsTo(Plan::class,'plan_id');
    }

    public function isExpired()
    {
    	return $this->suscription_end < date('Y-m-d');
    }
    public function getEstado()
    {
    	$estado ='';
    	if ($this->suscription_end < date('Y-m-d')) {
    		$estado ='Expirado';
    	}else{
    		$estado ='Vigente';
    	}
    	return $estado;
    }
    //retorna dias vigente de la suscripcion
    public function currentDays()
    {
    	$hoy = date_create(date('Y-m-d'));
    	$lastDate = date_create($this->suscription_end);
    	$interval  = date_diff($hoy,$lastDate);
    	$numDays = $interval->format('%R%a');
    	if ($numDays < 0) {
    		return 0;
    	}else{
    		return $interval->format('%a');
    	}
    }

    public function getTipo()
    {
        if($this->tipo === 'D') return "Revista Digital";

        return "Revista Física";

    }
}
