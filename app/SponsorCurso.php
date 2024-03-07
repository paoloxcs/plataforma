<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class SponsorCurso extends Model
{
    protected $table ='cursos_sponsors';
    protected $primaryKey = 'id';
    protected $fillable =['sponsor_id','curso_id','user_id'];

    public function sponsor()
    {
        return $this->belongsTo(Sponsor::class,'sponsor_id');
    }

	public function curso()
    {
        return $this->belongsTo(Curso::class,'curso_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    

}
