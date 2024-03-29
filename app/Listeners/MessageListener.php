<?php

namespace App\Listeners;

use App\Events\MessageEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class MessageListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  MessageEvent  $event
     * @return void
     */
    public function handle(MessageEvent $event)
    {
       /*$urlSite        = 'http://localhost:3000/';*/
       $urlSite        = 'https://constructivo.com:3000/';
       $urlWebSocket   = $urlSite.$event->endpoint;
       $dataParams     = http_build_query($event->params);
       $ch             = curl_init();
       try{
           curl_setopt($ch, CURLOPT_URL, $urlWebSocket);
           curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
           curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
           curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
           curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
           curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
           curl_setopt($ch, CURLOPT_POSTFIELDS, $dataParams);
           curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
           $response   = curl_exec($ch);
           $codeHttp   = curl_getinfo($ch, CURLINFO_HTTP_CODE);
           curl_close($ch);
           if($codeHttp != 200){
               return $response;
           }
           else{
               return false;
           }       
       }
       catch(Exception $e){
           return $e;
       }
    }
}
