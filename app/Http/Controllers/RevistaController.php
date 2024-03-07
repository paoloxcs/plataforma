<?php

namespace App\Http\Controllers;

use App\Publicacion;
use Illuminate\Http\Request;

class RevistaController extends Controller
{
	/*
	* Param : medio 
	* Ejemplo: RC, TM, DA
	*/
    public function getRevistas($medio)
    {
    	$revistas = Publicacion::where('medio',strtoupper($medio))->orderBy('idpublicacion','desc')->get();
    	return response()->json($revistas,200);
    }
}
