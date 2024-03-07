<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Editorial extends Model
{
    protected $table='editorial';
    protected $primaryKey ='ideditorial';
    protected $fillable =['ideditorial','nombre','pais'];
    public $timestamps =false;
    
}
