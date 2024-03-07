<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class NewSuscripDeposito extends Mailable
{
    use Queueable, SerializesModels;

    //La variable se declara publica para acceder manera direacta de la vista email
    public $data;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.newSuscripDeposito')
        ->subject('Bienvenido a la Plataforma de Capacitación');
        // ->subject('Bienvenido a la Plataforma de Ingeniería');
    }
}
