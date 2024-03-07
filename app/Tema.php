<?php

namespace App;
use DB;
use Illuminate\Database\Eloquent\Model;

class Tema extends Model
{
    protected $table ='temas_cursos';
    protected $primaryKey = 'id';
    protected $fillable =['descripcion','curso_id'];

}
