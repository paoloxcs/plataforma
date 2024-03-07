<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PagoUni extends Model
{
    protected $table = 'pagos_uni';
    protected $fillable = ['suscriptor_id', 'monto', 'tipo', 'metodopago_id', 'descrip', 'voucher_emit', 'nro_comprobante', 'moneda', 'num_operacion'];

    public function suscriptor()
    {
        return $this->belongsTo(SuscriptorDepositoUni::class, 'suscriptor_id');
    }
    public function metodoPago()
    {
        return $this->belongsTo(MetodoPago::class, 'metodopago_id');
    }

    public function getTipo()
    {
        if ($this->tipo === 'S') return "Suscripción";

        return "Renovación";
    }
}
