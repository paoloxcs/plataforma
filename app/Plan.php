<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    protected $table ='planes';
   protected $fillable = ['name', 'slug','descripcion', 'descripcion_m', 'descripcion_a', 'descripcion_c', 'precio', 'promocion', 'moneda', 'status', 'meses', 'id_culqi'];


    public function suscriptor()
    {
        return $this->hasMany(SuscriptorDeposito::class);
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
    public function promociones()
    {
        return $this->hasMany(Promocion::class);
    }
}

