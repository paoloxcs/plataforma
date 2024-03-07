<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class SponsorMaterial extends Model
{
    protected $table ='sponsors_material';
    protected $primaryKey = 'id';
    protected $fillable =['doc_name','url_doc','sponsor_id'];

    public function sponsor()
    {
        return $this->belongsTo(Sponsor::class,'sponsor_id');
    }

    

}
