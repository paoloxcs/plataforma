<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Sponsor extends Model
{
    protected $table ='sponsor';
    protected $primaryKey = 'id';
    protected $fillable =['nombre','url_logo','url_web'];

    public function countMateriales()
    {
         $totalmateriales = DB::table('sponsors_material as c')
        ->where('c.sponsor_id','=',$this->id)->count();
        return $totalmateriales;
    }

    public function countContactos()
    {
         $totalcontactos = DB::table('sponsors_contacts as c')
        ->where('c.sponsor_id','=',$this->id)->count();
        return $totalcontactos;
    }
   

  

}
