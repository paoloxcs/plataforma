<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Colaboradores extends Model
{
    protected $table ='colaboradores';
    protected $primaryKey = 'id';
    protected $fillable =['nombre','rubro_id','prioridad','estado','url_logo','url_logo_w','descripcion','orden'];
    


     public function rubro()
    {
        return $this->belongsTo(Rubro::class,'rubro_id');
    }

  

}
