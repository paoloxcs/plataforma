<?php 

use App\Log;
use App\Notification;
use App\Promocion;
use App\Publicacion;
use App\Record;
function create_slug($string, $replace = array(), $delimiter = '-'){
    // Validacion de acotejamiento utf-8
    if (!extension_loaded('iconv')) {
      throw new Exception('iconv module not loaded');
    }
    // Obtener cotejamiento por defecto y pasar a UTF-8
    $oldLocale = setlocale(LC_ALL, '0');
    setlocale(LC_ALL, 'en_US.UTF-8');
    $clean = iconv('UTF-8', 'ASCII//TRANSLIT', $string);
    if (!empty($replace)) {
      $clean = str_replace((array) $replace, ' ', $clean);
    }
    $clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $clean);
    $clean = strtolower($clean);
    $clean = preg_replace("/[\/_|+ -]+/", $delimiter, $clean);
    $clean = trim($clean, $delimiter);
    // Revert back to the old locale
    setlocale(LC_ALL, $oldLocale);
    return $clean;
}

function lastEdition()
{
    $edicion = Publicacion::where('suplemento','=',1)->orderBy('nro','DESC')->first();
    return $edicion;
}
function show_btnPanel()
{
    return Auth()->user()->role->grupo === 'panel';
}
function show_btnEjecutivo()  
{
  // if(Auth()->user()->role->grupo === 'panel'){
  //   return true;
  // }else 
  if(Auth()->user()->ejecutivo ){
    return true; 
  }else{
    return false;
  }
    
}
function getLocation()
{
  //Conexion a la api de GEOPLUGIN para obtner la localizacion del usuario
  $user_ip = $_SERVER['REMOTE_ADDR'];
  /*$user_ip ='190.235.119.187';*/
  $meta = unserialize(file_get_contents('http://www.geoplugin.net/php.gp?ip='.$user_ip));
  $location =[
      'country_code' => $meta['geoplugin_countryCode'],
      'region'       => $meta['geoplugin_regionName'],
      'pais'         => $meta['geoplugin_countryName']
  ];
  
  return $location;
}

function countNotifications_noreaded()
{
  return Notification::where('is_readed','=',0)->count();
}

function promoActive()
{
  $promo = Promocion::where('estado','=',1)->first();
  return $promo;
}

function saveRecord($user_id, $body)
{
  // Guardando historial
  Record::create([
    'user_id'   =>  $user_id,
    'gestor_id' =>  Auth()->user()->id,
    'body'      =>  $body,
  ]);
}

function create_user_log($body)
{
  Log::create([
    'user_id' =>  Auth()->user()->id,
    'body'    =>  $body,
  ]);
}

