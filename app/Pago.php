<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pago extends Model
{
    protected $fillable =['suscriptor_id','monto','tipo','metodopago_id','descrip','voucher_emit','nro_comprobante','moneda','num_operacion'];

    public function suscriptor()
    {
    	return $this->belongsTo(SuscriptorDeposito::class,'suscriptor_id');
    }
    //Nuevo Pago Efectivo
    public function suscriptor_efectivo()
    {
        return $this->belongsTo(SuscriptorEfectivo::class, 'suscriptor_id');
    }
    //PAGOS YAPE
    public function suscriptor_yape()
    {
        return $this->belongsTo(SuscriptorYape::class, 'suscriptor_id');
    }
    public function metodoPago()
    {
    	return $this->belongsTo(MetodoPago::class,'metodopago_id');
    }

    public function getTipo()
    {
    	if($this->tipo ==='S') return "Suscripción";

    	return "Renovación";
    }
    

}
