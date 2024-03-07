<?php

namespace App\Http\Controllers;

use App\Curso;
use App\MetodoPago;
use App\Pago;
use App\PaypalClient;
use App\Plan;
use App\Rubro;
use App\SuscriptorCursos;
use App\SuscriptorDeposito;
use App\SuscriptorPaypalCursos;
use App\SuscriptorRecurrentePaypal;
use App\User;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

use GuzzleHttp\Client;

class PaypalController extends Controller
{
    public function __construct()
    {
    }

    //Suscripcion Curso Paypal
    public function suscripcionPaypalCurso(Request $request)
    {
        // $curso = Curso::find($request->cursoId);
        $curso = Curso::where('slug', $request->cursoSlug)->with('autor', 'rubro')->first();

        $rubro = Rubro::where('idrubro', $curso->rubro_id)->first();
        // $pago = $request->amount * 100;
        // $moneda = $request->currency;
        $moneda = App::getLocale();
        $plan = Plan::where('id', '2')->first();
        $paymentId = $request->transactionId;

        $metodo_pago = MetodoPago::where('name', 'Paypal')->first();
        if (!$metodo_pago) {
            $metodo_pago =  DB::insert('insert into metodos_pago (name) values (?)', ['Paypal']);
        }

        //USER NO SUSC - SE HACE UNA SUSC SIMPLE
        if (Auth()->user()->isPremium()) {
        } else {

            if ($curso->rubro->idrubro != 1 and $curso->fecha_culminacion >= date('Y-m-d')) {
                $usr = User::find(Auth()->user()->id);
                $usr->role_id = 2;
                $usr->save();

                $suscrip = new SuscriptorDeposito();
                $suscrip->user_id = $usr->id;
                $suscrip->plan_id = $plan->id;
                $suscrip->suscription_init = date('Y-m-d');
                $suscrip->suscription_end = date('Y-m-d', strtotime(date('Y-m-d') . "+ 1 year"));
                $suscrip->medio = 'RC';
                $suscrip->tipo = 'D';
                $suscrip->metodopago_id =  $metodo_pago->id; //Pago Paypal
                $suscrip->gestor_id = '18207'; //User Plataform
                $suscrip->save();

                //Guardando pago
                Pago::create([
                    'suscriptor_id' =>  $suscrip->id,
                    'monto'         =>  0.00,
                    'moneda'         =>  $plan->moneda,
                    'nro_comprobante' => 'C_PAY-' . $paymentId,
                    'metodopago_id' =>  2,
                    'voucher_emit' =>  2
                ]);
            }
        }

        //REGISTRO DE CURSO - USER
        // $suscrip = SuscriptorDeposito::where('user_id',Auth()->user()->id)->first();        
        //GRATIS PLATAFORMA 
        if ($curso->fecha_culminacion < date('Y-m-d')) {
            $nuevafecha = strtotime('+ 1 month', strtotime(date('Y-m-d')));
            $suscriptor = SuscriptorCursos::create([
                /*'user_id' =>  Auth()->user()->id,*/
                'user_id' =>  Auth()->user()->id,
                'curso_id' =>  $curso->id,
                'id_culqi' => 'Null',
                'payment_id' => $paymentId,
                'type_pay' => 'paypal',
                'nro_comprobante' => 'C_PAY-' . $paymentId,
                'suscription_end' => date('Y-m-d', $nuevafecha),
                'responsable' => "18207", //User Plataform
                'moneda' => $moneda,
            ]);
        } else {
            $suscriptor = SuscriptorCursos::create([
                'user_id' =>  Auth()->user()->id,
                'curso_id' =>  $curso->id,
                'id_culqi' => 'Null',
                'payment_id' => $paymentId,
                'type_pay' => 'paypal',
                'nro_comprobante' => 'C_PAY-' . $paymentId,
                'responsable' => "18207", //User Plataform
                'moneda' => $moneda,
            ]);
        }

        // SESSION PAY
        Session::flash('success_pay', [
            'course' => $curso,
            'plan' => null,
            'purchasenumber' => $paymentId,
            'simbolo' => $request->simbolo,
            'precio_r' => $request->precio_r,
            'precio' => $request->precio,
            'descuento' => $request->descuento,
            'method' => 'paypal',
            'suscriptor_recurrente' => null
        ]);

        return response()->json(['message' => 'Registro exitoso!', 'status' => 200]);
    }

    //Suscripcion Deposito Paypal
    public function suscripcionPaypalRecurrente(Request $request)
    {
 
        //recuperar plan seleccionado
        $plan = Plan::find($request->plan_id);
        $paymentId = $request->transactionId;

        if ($plan->promocion > 0) {
            $amount = $plan->promocion; //RECUPERA EL PRECIO DE LA PROMOCION
        } else {
            $amount = $plan->precio; //RECUPERA EL PRECIO YA QUE NO EXISTE PROMOCION
        }

        // Definiendo fecha de caducidad
        $suscription_init = date('Y-m-d');
        $new_date = strtotime('+' . $plan->meses . ' month', strtotime($suscription_init));
        $suscription_end = date('Y-m-d', $new_date);

        $metodo_pago = MetodoPago::where('name', 'Paypal')->first();
        if (!$metodo_pago) {
            $metodo_pago =  DB::insert('insert into metodos_pago (name) values (?)', ['Paypal']);
        }

        //Insertar en la tabla suscriptores_deposito
        $suscrip = new SuscriptorDeposito();
        $suscrip->user_id = Auth()->user()->id;
        $suscrip->plan_id = $plan->id;
        $suscrip->suscription_init = $suscription_init;
        $suscrip->suscription_end = $suscription_end;
        // $suscrip->medio = 'RC';
        // $suscrip->tipo = 'D';
        $suscrip->metodopago_id = $metodo_pago->id;
        $suscrip->gestor_id = '18207';
        $suscrip->save();

        // // Actualizando rol del usuario
        $currentUser  = User::find(Auth()->user()->id);
        $currentUser->role_id = 2;
        $currentUser->save();

        //Guardando pago
        Pago::create([
            'suscriptor_id' =>  $suscrip->id,
            'monto'         =>  $amount,
            'moneda'         =>  $plan->moneda,
            'nro_comprobante' => 'S_PAY_' . $paymentId,
            'metodopago_id' =>  2,
            'voucher_emit' =>  2
        ]);

        //Enviar correo
        // $data = [
        //     'name' => $request->name,
        //     'email' => $request->email,
        //     'password' => $request->password,
        //     'caducidad' => $request->suscription_end
        // ];
        // Mail::to($request->email)
        //     ->send(new NewSuscripDeposito($data));
        //Enviar correo
        // $dataC = [
        //     'name' => $request->name . ' ' . $request->last_name,
        //     'suscription_init' => date('Y-m-d'),
        //     'doc_number' => $request->doc_number,
        //     'phone' => $request->phone_number,
        //     'email' => $request->email,
        //     'nro_comprobante' => $request->nro_comprobante,
        //     'gestor' => $gestor->fullName(),
        //     'plan' => $plan->name,
        //     'precio' => $request->monto,
        //     'message' => 'Nueva suscripción en Plataforma',
        //     'data' => 0,
        //     'moneda' => $plan->moneda,
        // ];
        // Mail::to('cobranzas@constructivo.com')
        //     ->cc('postmaster3@constructivo.com')
        //     ->send(new NewSuscripDepositoC($dataC));

        // create_user_log('Se suscribio con paypal ' . strtoupper($user->fullName())); // Crea un log en el sistema

        // $suscriptor_recurrente = SuscriptorRecurrentePaypal::where('paypal_agreement_id', $suscrip->paypal_agreement_id)->where('user_id', auth()->user()->id)->first();
        $suscriptor_recurrente = SuscriptorDeposito::where('id', $suscrip->id)->where('user_id', auth()->user()->id)->first();
        
        // SESSION PAY
        Session::flash('success_pay', [
            'course' => null,
            'plan' => $plan,
            'purchasenumber' => $paymentId,
            'simbolo' => $request->simbolo,
            'precio_r' => $request->precio_r,
            'precio' => $request->precio,
            'descuento' => $request->descuento,
            'method' => 'paypal',
            'suscriptor_recurrente' => $suscriptor_recurrente
        ]);

        // return response()->json([
        //     'success' => true
        // ], 201);

        return response()->json(['message' => 'Registro exitoso', 'status' => 200]);

    }
}
