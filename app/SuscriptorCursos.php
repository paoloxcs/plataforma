<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SuscriptorCursos extends Model
{
    protected $table ='suscriptores_cursos';
    protected $fillable =['user_id','curso_id','id_culqi','responsable','nro_comprobante','compra','suscription_end','moneda','num_operacion','pago_monto'];

   // public $timestamps = false;

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    

    public function gestor()
    {
        return $this->belongsTo(User::class,'responsable');
    }

     public function curso()
    {
        return $this->belongsTo(Curso::class,'curso_id');
    }

   
}
