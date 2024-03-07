<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    //
    protected $fillable=['title', 'url_web', 'url_image','type_event_id', 'rubro_id','date_init', 'status'];
    public $timestamps=false;

    public function type_event()
    {
    	return $this->belongsTo(TypeEvent::class, 'type_event_id');
    }
    public function rubro()
    {
    	return $this->belongsTo(Rubro::class, 'rubro_id');
    }
}
