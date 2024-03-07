<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class SponsorContact extends Model
{
    protected $table ='sponsors_contacts';
    protected $primaryKey = 'id';
    protected $fillable =['nombre','email','sponsor_id'];

    public function sponsor()
    {
        return $this->belongsTo(Sponsor::class,'sponsor_id');
    }

    

}
