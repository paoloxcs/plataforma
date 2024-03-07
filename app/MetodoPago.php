<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MetodoPago extends Model
{
    protected $table ='metodos_pago';

    protected $fillable =['name'];

    public function suscriptores()
    {
    	return $this->hasMany(SuscriptorDeposito::class,'metodopago_id');
    }
    //Nuevo Pago Efectivo
    public function suscriptores_efectivo()
    {
        return $this->hasMany(SuscriptorEfectivo::class, 'metodopago_id');
    }
    //PAGOS YAPE
    public function suscriptores_yape()
    {
        return $this->hasMany(SuscriptorYape::class, 'metodopago_id');
    }
    public function pagos()
    {
    	return $this->hasMany(Pago::class,'metodopago_id');
    }
}
