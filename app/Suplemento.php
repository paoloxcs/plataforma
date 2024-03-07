<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Suplemento extends Model
{
    protected $table ='suplemento';
    protected $primaryKey ='idsuplemento';

    protected $fillable = ['nroedicion', 'nombre'];
    
}
