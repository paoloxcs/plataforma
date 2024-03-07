<?php

namespace App\Http\Controllers;

use App\Asignacion;
use App\Interes;
use App\MetodoPago;
use App\Pago;
use App\PagoUni;
use App\Plan;
use App\SuscriptorDepositoUni;
use App\University;
use App\User;
use DateTime;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Facades\Session as FacadesSession;
use Maatwebsite\Excel\Facades\Excel;

class UniversityController extends Controller
{
    

    public function get_register_ucal()
    {
        if (!Auth::guest()) {
            return redirect()->back();
        } else {
            $data = ['active_uni' => 'UCAL'];
            return view('web.uni.ucal', $data);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:45',
            'last_name' => 'required|string|max:45',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'phone_number'  => 'required|numeric',
            'medio'        =>  'required',
            // 'age'  => 'nullable|numeric|min:18|max:150',
            'age'  => 'required|date_format:Y-m-d',
            'address'  => 'required',
            'doc_number' => 'required',
            'profession' => 'required',
            'cargo_user' => 'required',
            'pais'  => 'required',
        ], [
            'name.required' => 'Ingrese los nombres',
            'last_name.required' => 'Ingrese los apellidos',
            'email.required' => 'Ingrese el correo electrónico',
            'password.required' => 'Ingrese contraseña',
            'phone_number.required' => 'Ingrese el número de teléfono',
            // 'age.min' => 'La edad debe tener :min +',
            // 'age.max' => 'La edad no puede exeder de 150',
            'age.required' => 'Ingrese la fecha de nacimineto',
            'age.date_format' => 'La fecha de nacimineto es invalido',
            'medio.required'      => 'Elige al menos un medio de Interés',
            'address.required'  => 'Ingrese una dirección',
            'doc_number.required' => 'Ingrese el documento de identidad',
            'profession.required' => 'Ingrese la profesión',
            'cargo_user.required' => 'Ingrese la carrera/programa',
            'pais.required' => 'Seleccione un país',
        ]);
        if ($validator->fails()) {
            FacadesSession::flash('msg-error', 'Hubo un error, intente nuevamente');
            return redirect()->back()->withErrors($validator->errors());
        }

        // $gestor = User::where('id', $request->gestor_a)->first();
        $gestor_id =  '18207'; //User Plataform

        //Insertar en la tabla users
        $user = new User();

        $user->name = $request->name;
        $user->last_name = $request->last_name;
        $user->email = strtolower($request->email);
        $user->password = bcrypt($request->password);
        $user->role_id = 2;
        //Nuevos Campos requeridos
        $user->age = $request->age;
        $user->phone_number = $request->phone_number;
        $user->doc_number = $request->doc_number;
        $user->profession = $request->profession;
        $user->cargo_user = $request->cargo_user;
        $user->address = $request->address;
        $user->pais = $request->pais;
        //Nuevos Campos requeridos
        $user->save();

        Interes::create([
            'user_id'   =>  $user->id,
            'medio_id'  => $request->medio,
        ]);

        $universities = University::create([
            'user_id' => $user->id,
            'name' => $request->active_uni,
        ]);

        //recuperar plan seleccionado
        // $plan = Plan::find($request->plan);
        $plan = Plan::where('meses', '6')->where('moneda', 'PEN')->where('status', 1)->first();

        // Definiendo proxima fecha de caducidad
        $nuevafecha = strtotime('+' . $plan->meses . ' month', strtotime(date('Y-m-d')));
        $suscription_end = date('Y-m-d', $nuevafecha);

        //Insertar en la tabla suscriptores_deposito
        $suscrip = new SuscriptorDepositoUni();
        $suscrip->user_id = $user->id;
        $suscrip->plan_id = $plan->id;
        $suscrip->suscription_init = date('Y-m-d');
        $suscrip->suscription_end = $suscription_end; //Calculo
        $suscrip->medio = $request->medio;
        $suscrip->tipo = 'D';
        $suscrip->metodopago_id = 2;
        $suscrip->gestor_id = $gestor_id;
        $suscrip->save();

        //Guardando pago
        PagoUni::create([
            'suscriptor_id' =>  $suscrip->id,
            'monto'         =>  '0.00',
            'moneda'         =>  $plan->moneda,
            'nro_comprobante' => 'Cortesía ' . $request->active_uni,
            //Nuevos Campos requeridos     
            'num_operacion' => 'Cortesía ' . $request->active_uni,
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

        Auth::login($user);

        create_user_log('Se suscribio un universitario.' . strtoupper($user->fullName())); // Crea un log en el sistema

        return redirect()->route('home');
    }


    //NEW LIST
    public function getPremiumList()
    {
        $asesores = User::where('role_id', 8)->orWhere('role_id', 6)->get();

        $planes = Plan::where('status', 1)->get();
        // $planes = Plan::where('id_culqi', '!=', null)->orderBy('status', 'desc')->get();
        $planes_off = Plan::where('id_culqi', '!=', null)->where('status', 0)->orderBy('status', 'desc')->get();
        $metodo_pagos = MetodoPago::where('name', '<>', 'Recurrente')->get();

        $suscriptores_premium_query =  SuscriptorDepositoUni::join('users', function ($join) {
            $join->on('suscriptores_deposito_uni.gestor_id', '=', 'users.id')
                ->where('users.id', '=', Auth()->user()->id)->orWhere('users.id', '=', '18207');
        })->when(request('order') ?? 'new', function ($query, $order) {
            $sort = $order === 'new' ? 'desc' : 'asc';
            $query->orderBy('suscription_init',  $sort);
        })->when(request('search') ?? null, function ($query, $buscar) {
            $query->join('users as u', 'u.id', '=', 'suscriptores_deposito_uni.user_id')
                ->where(function ($query) use ($buscar) {
                    $query->where(DB::raw('concat(u.name," ",u.last_name)'), 'like', '%' . $buscar . '%')
                        ->orWhere('u.email', 'like', '%' . $buscar . '%')
                        ->orWhere('u.phone_number', 'like', '%' . $buscar . '%');
                });
        })->when(request('plan') ?? null, function ($query, $plan) {
            $query->where('plan_id', $plan);
        })->when(request('modpago') ?? null, function ($query, $modpago_id) {
            $query->where('metodopago_id', $modpago_id);
        })->when(request('asesor') ?? null, function ($query, $asesor) {
            $query->where([['gestor_id', $asesor]]);
        })->when(request('fecha_start') ?? null, function ($query, $data_fecha_start) {
            $query->where('suscription_init', '>=', $data_fecha_start);
        })->when(request('fecha_end') ?? null, function ($query, $data_fecha_end) {
            $query->where('suscription_init',  '<=', $data_fecha_end);
        })->when(request('status') ?? null, function ($query, $status) {
            if ($status == 1) {
                $query->where('suscription_end', '>', date('Y-m-d'));
            } else {
                $query->where('suscription_end', '<', date('Y-m-d'));
            }
        })->select('suscriptores_deposito_uni.*');

        if (Auth()->user()->isAdmin() or Auth()->user()->isSuscriptorManager()) {
            $suscriptores_premium_query =  SuscriptorDepositoUni::when(request('order') ?? 'new', function ($query, $order) {
                $sort = $order === 'new' ? 'desc' : 'asc';
                $query->orderBy('suscription_init',  $sort);
            })->when(request('search') ?? null, function ($query, $buscar) {
                $query->join('users as u', 'u.id', '=', 'suscriptores_deposito_uni.user_id')
                    ->where(function ($query) use ($buscar) {
                        $query->where(DB::raw('concat(u.name," ",u.last_name)'), 'like', '%' . $buscar . '%')
                            ->orWhere('u.email', 'like', '%' . $buscar . '%')
                            ->orWhere('u.phone_number', 'like', '%' . $buscar . '%');
                    });
            })->when(request('plan') ?? null, function ($query, $plan) {
                $query->where('plan_id', $plan);
            })->when(request('modpago') ?? null, function ($query, $modpago_id) {
                $query->where('metodopago_id', $modpago_id);
            })->when(request('asesor') ?? null, function ($query, $asesor) {
                $query->where([['gestor_id', $asesor]]);
            })->when(request('fecha_start') ?? null, function ($query, $data_fecha_start) {
                $query->where('suscription_init', '>=', $data_fecha_start);
            })->when(request('fecha_end') ?? null, function ($query, $data_fecha_end) {
                $query->where('suscription_init',  '<=', $data_fecha_end);
            })->when(request('status') ?? null, function ($query, $status) {
                if ($status == 1) {
                    $query->where('suscription_end', '>', date('Y-m-d'));
                } else {
                    $query->where('suscription_end', '<', date('Y-m-d'));
                }
            })->select('suscriptores_deposito_uni.*');
        }

        $suscriptores_premium = $suscriptores_premium_query->with('user', 'pagos', 'plan', 'gestor')->orderBy('id',  'desc')->paginate(8);
        $suscriptores_premium_count = $suscriptores_premium_query->count();
        if (request('count_premium')) {
            $suscriptores_premium_count = request('count_premium');
        }
        return view('panel.subscriber.deposito_uni.index', compact('suscriptores_premium', 'suscriptores_premium_count', 'planes', 'planes_off', 'metodo_pagos', 'asesores'));
    }



    public function updatePremium(Request $request, $id)
    {
        $validation = \Validator::make($request->all(), [
            'name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|email|unique:users,email,' . $id . ',id',
            //Nuevos Campos requeridos
            'phone_number' => 'required',
            'address' => 'required',
            'doc_number' => 'required',
            'profession' => 'required',
            'cargo_user' => 'required',
            'num_operacion' => 'required',
            //Nuevos Campos requeridos
        ], [
            'email.unique' => 'El correo ingresado ya existe!'
        ]);
        if ($validation->fails()) {
            return response()->json(['errors' => $validation->errors(), 'status' => 422]);
        } else {
            $gestor = User::where('id', $request->gestor_a)->first();


            $user = User::find($id);
            $user->name = $request->name;
            $user->last_name = $request->last_name;
            $user->email = $request->email;
            //Nuevos Campos requeridos
            $user->phone_number = $request->phone_number;
            $user->doc_number = $request->doc_number;
            $user->profession = $request->profession;
            $user->cargo_user = $request->cargo_user;
            $user->address = $request->address;
            //Nuevos Campos requeridos
            $user->save();

            $suscripDep = SuscriptorDepositoUni::where('user_id', $id)->first();
            $plan = Plan::find($request->plan);

            if ($suscripDep->suscription_end != $request->suscription_end) {
                $validation = \Validator::make($request->all(), [
                    'nro_comprobante' => 'required|string',
                    'monto' => 'required|numeric',
                ]);
                if ($validation->fails()) {
                    return response()->json(['errors' => $validation->errors(), 'status' => 422]);
                }
                $suscripDep->suscription_end = $request->suscription_end;
                $suscripDep->plan_id = $plan->id;
                $suscripDep->gestor_id = $request->gestor_a;
                $suscripDep->save();


                PagoUni::create([
                    'suscriptor_id' =>  $suscripDep->id,
                    'monto'         =>  $request->monto,
                    'nro_comprobante' => $request->nro_comprobante,
                    //Nuevos Campos requeridos
                    'num_operacion' => $request->num_operacion,
                    'tipo'          =>  'R',
                    'metodopago_id' =>  2,
                    'voucher_emit'  =>  2,
                    'moneda' => $plan->moneda,
                ]);


                // // Enviando correo al usuario
                // $data = [
                //     'username'  =>  $suscripDep->user->fullName(),
                //     'caducidad' =>  $suscripDep->suscription_end
                // ];
                // Mail::to($suscripDep->user->email)
                //     ->send(new updateCaducidad($data));

                // //Enviar correo
                // $dataC = [
                //     'name' => $suscripDep->user->fullName(),
                //     'suscription_init' => date('Y-m-d'),
                //     'doc_number' => $request->doc_number,
                //     'phone' => $request->phone_number,
                //     'email' => $request->email,
                //     'nro_comprobante' => $request->nro_comprobante,
                //     'gestor' => $gestor->fullName(),
                //     'plan' => $plan->name,
                //     'precio' => $request->monto,
                //     'message' => 'Renovación de suscripción en Plataforma',
                //     'data' => 0,
                //     'moneda' => $plan->moneda,
                // ];
                // Mail::to('cobranzas@constructivo.com')
                //     ->cc('postmaster3@constructivo.com')
                //     ->send(new NewSuscripDepositoC($dataC));


                create_user_log('Renovó la suscripción de ' . strtoupper($user->fullName())); // Crea un log en el sistema

            }

            $suscripDep->medio = $request->medio;
            $suscripDep->tipo = $request->modalidad;
            $suscripDep->gestor_id = $request->gestor_a;
            $suscripDep->save();

            create_user_log('Actualizó los datos de ' . strtoupper($user->fullName()));

            return response()->json(['message' => 'Actualizacion exitosa', 'status' => 200]);
        }
    }

    public function destroyPremium($id)
    {
        $user = User::find($id);

        $suscrip = SuscriptorDepositoUni::where('user_id', '=', $user->id)->first();
        $suscrip->delete();


        $user->role_id = 7;
        $user->save();

        $asignation = Asignacion::where('suscriptor_id', $id)->first();
        if ($asignation) {
            $asignation->is_confirmed = 0;
            $asignation->save();
        }


        create_user_log('Anuló la suscripción de ' . strtoupper($user->fullName())); // Crea un log en el sistema

        return response()->json(['message' => 'Suscripcion anulada', 'status' => 200]);
    }


    //New Export de Excel Deposito
    public function dowloadDataPremiumFilter()
    {
        $suscriptores_premium_query =  SuscriptorDepositoUni::join('users', function ($join) {
            $join->on('suscriptores_deposito.gestor_id', '=', 'users.id')
                ->where('users.id', '=', Auth()->user()->id)->orWhere('users.id', '=', '18207');
        })->when(request('order') ?? 'new', function ($query, $order) {
            $sort = $order === 'new' ? 'desc' : 'asc';
            $query->orderBy('suscription_init',  $sort);
        })->when(request('search') ?? null, function ($query, $buscar) {
            $query->join('users as u', 'u.id', '=', 'suscriptores_deposito.user_id')
                ->where(function ($query) use ($buscar) {
                    $query->where(DB::raw('concat(u.name," ",u.last_name)'), 'like', '%' . $buscar . '%')
                        ->orWhere('u.email', 'like', '%' . $buscar . '%')
                        ->orWhere('u.phone_number', 'like', '%' . $buscar . '%');
                });
        })->when(request('plan') ?? null, function ($query, $plan) {
            $query->where('plan_id', $plan);
        })->when(request('modpago') ?? null, function ($query, $modpago_id) {
            $query->where('metodopago_id', $modpago_id);
        })->when(request('asesor') ?? null, function ($query, $asesor) {
            $query->where([['gestor_id', $asesor]]);
        })->when(request('fecha_start') ?? null, function ($query, $data_fecha_start) {
            $query->where('suscription_init', '>=', $data_fecha_start);
        })->when(request('fecha_end') ?? null, function ($query, $data_fecha_end) {
            $query->where('suscription_init',  '<=', $data_fecha_end);
        })->when(request('status') ?? null, function ($query, $status) {
            if ($status == 1) {
                $query->where('suscription_end', '>', date('Y-m-d'));
            } else {
                $query->where('suscription_end', '<', date('Y-m-d'));
            }
        })->select('suscriptores_deposito.*');

        if (Auth()->user()->isAdmin() or Auth()->user()->isSuscriptorManager()) {
            $suscriptores_premium_query =  SuscriptorDepositoUni::when(request('order') ?? 'new', function ($query, $order) {
                $sort = $order === 'new' ? 'desc' : 'asc';
                $query->orderBy('suscription_init',  $sort);
            })->when(request('search') ?? null, function ($query, $buscar) {
                $query->join('users as u', 'u.id', '=', 'suscriptores_deposito.user_id')
                    ->where(function ($query) use ($buscar) {
                        $query->where(DB::raw('concat(u.name," ",u.last_name)'), 'like', '%' . $buscar . '%')
                            ->orWhere('u.email', 'like', '%' . $buscar . '%')
                            ->orWhere('u.phone_number', 'like', '%' . $buscar . '%');
                    });
            })->when(request('plan') ?? null, function ($query, $plan) {
                $query->where('plan_id', $plan);
            })->when(request('modpago') ?? null, function ($query, $modpago_id) {
                $query->where('metodopago_id', $modpago_id);
            })->when(request('asesor') ?? null, function ($query, $asesor) {
                $query->where([['gestor_id', $asesor]]);
            })->when(request('fecha_start') ?? null, function ($query, $data_fecha_start) {
                $query->where('suscription_init', '>=', $data_fecha_start);
            })->when(request('fecha_end') ?? null, function ($query, $data_fecha_end) {
                $query->where('suscription_init',  '<=', $data_fecha_end);
            })->when(request('status') ?? null, function ($query, $status) {
                if ($status == 1) {
                    $query->where('suscription_end', '>', date('Y-m-d'));
                } else {
                    $query->where('suscription_end', '<', date('Y-m-d'));
                }
            })->select('suscriptores_deposito.*');
        }

        // subscribers prmeium
        $subscribers = $suscriptores_premium_query->with('user', 'pagos', 'plan', 'gestor')->orderBy('id',  'desc')->get();

        Excel::create('suscriptores-premium', function ($excel) use ($subscribers) {
            $excel->sheet('Suscriptores premium', function ($sheet) use ($subscribers) {

                // Cabecra del archivo excel
                $sheet->row(1, [
                    'Nombres y apellidos',
                    'Correo',
                    //NEW CABECERA
                    // 'Acceso',
                    'Dirección',
                    'Cargo',
                    'Profesión',
                    'Edad',
                    'N° telf.',
                    'Universidad',
                    'Caducidad',
                    'Medio',
                    'Intereses',
                    'Plan',
                    'Nro. Comp.',
                    'Nro. Oper.',
                    'Monto',
                    'Ult. Pago',
                    'Estado',
                    'Gestor'
                ]);

                $sheet->row(1, function ($row) {
                    // call cell manipulation methods
                    $row->setBackground('#000000');
                    $row->setFontColor('#FFFFFF');
                });


                // Datos en en archivo excel
                foreach ($subscribers as $index => $subs) {

                    $nacimiento = new DateTime($subs->age);
                    $ahora = new DateTime(date('Y-m-d'));
                    $diferencia = $ahora->diff($nacimiento);
                    $age = $diferencia->format('%y') . ' años';


                    //JHED SP-P
                    $pagos = PagoUni::where('suscriptor_id', '=', $subs->id)->orderBy('id', 'desc')->first();
                    if ($pagos) {
                        $subs['pago_nro_comprobante'] = $pagos->nro_comprobante;
                        $subs['pago_nro_operacion'] = $pagos->num_operacion;
                        $subs['pago_time'] = $pagos->created_at;
                        $subs['pago_moneda'] =  $pagos->moneda;
                        $subs['pago_monto'] = $pagos->monto;
                    }

                    $sheet->row($index + 2, [
                        $subs->user->fullName(),
                        $subs->user->email,
                        // $acceso,
                        $subs->user->address ?  $subs->user->address : ' - ',
                        $subs->user->cargo_user ?  $subs->user->cargo_user : ' - ',
                        $subs->user->profession ?  $subs->user->profession : ' - ',
                        $subs->age ? $age : ' - ',
                        $subs->user->phone_number,
                        $subs->user->universities()->first()->name,
                        date('d/m/Y', strtotime($subs->suscription_end)),
                        $subs->medio,
                        count($subs->user->intereses) == 1  ?  $subs->user->intereses[0]->medio->name : (count($subs->user->intereses) == 2  ? $subs->user->intereses[0]->medio->name . '  y  ' . $subs->user->intereses[1]->medio->name : (count($subs->user->intereses) == 3  ? $subs->user->intereses[0]->medio->name . ', ' . $subs->user->intereses[1]->medio->name . '  y  ' . $subs->user->intereses[2]->medio->name : ' ')),
                        'S/. ' . $subs->plan->precio,
                        $subs->pago_nro_comprobante,
                        $subs->pago_nro_operacion,
                        ($subs->pago_moneda == "PEN" ? 'S/. ' : '$ ') . $subs->pago_monto,
                        date('d/m/Y', strtotime($subs->pago_time)),
                        $subs->suscription_end > date('Y-m-d') ? 'Vigente' : 'Expirado',
                        $subs->gestor->name,
                    ]);
                }
            });
        })->export('xls');
    }
}
