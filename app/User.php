<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Cache;
use DB;


class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'last_name', 'email', 'password', 'address', 'pais', 'phone_number', 'doc_number', 'age', 'profession', 'role_id', 'url_foto', 'slugplan','cargo_user'
    ];

    /*public $timestamps = false;*/

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class,'role_id');
    }
    //relacion si el rol es ejectuvo.
    public function clientes()
    {
        return $this->belongsToMany(Cliente::class, 'clientes_ejecutivos','user_id');
    }
    
    // JHED EJECUTIVO
    public function ejecutivo()
    {
        return $this->hasOne(Ejecutivo::class, 'idejecutivo');
    }
    
    public function cliente()
    {
        return $this->hasOne(Cliente::class);
    }
    public function suscriptorDeposito()
    {
        return $this->hasOne(SuscriptorDeposito::class);
    }
    public function suscriptorDepositoUni()
    {
        return $this->hasOne(SuscriptorDepositoUni::class);
    }
    //Nuevo Pago Efectivo
    public function suscriptorEfectivo()
    {
        return $this->hasOne(SuscriptorEfectivo::class);
    }  
    //PAGOS YAPE
    public function suscriptorYape()
    {
        return $this->hasOne(SuscriptorYape::class);
    }
    public function suscriptorRecurrente()
    {
        return $this->hasOne(SuscriptorRecurrente::class);
    }

    public function suscriptorOnline()
    {
        return $this->hasOne(SuscriptorOnline::class);
    }
    public function valoraciones()
    {
        return $this->hasMany(Valoracion::class);
    }
    public function comentarios()
    {
        return $this->hasMany(Comentario::class);
    }
    public function respuestas()
    {
        return $this->hasMany(Respuesta::class);
    }
    public function postsMarcados()
    {
        return $this->hasMany(UserStorage::class);
    }
    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }
    //asignaciones del gestor de suscripcion
    public function myAsignations()
    {
        return $this->hasMany(Asignacion::class,'gestor_id');
    }
    public function asignacion()
    {
        return $this->hasOne(Asignacion::class,'suscriptor_id');
    }
    public function records()
    {
        return $this->hasMany(Record::class,'user_id');
    }
    public function recordsByme()
    {
        return $this->hasMany(Record::class,'gestor_id');
    }
    public function intereses()
    {
        return $this->hasMany(Interes::class);
    }

    public function logs()
    {
        return $this->hasMany(Log::class);
    }

    public function fullName()
    {
        return $this->name.' '.$this->last_name;
    }

    //Metodos para validaciones
    public function isFree()
    {
        //role_id 7 = Suscriptor Gratis
        return $this->role_id === 7;
    }

    public function isAdmin()
    {
        //role_id 1 = Administrador
        return $this->role_id === 1;
    }

     public function isContentManager()
    {
        //role_id 3 = Content Manager
        return $this->role_id === 3;
    }

    public function isSuscriptorManager()
    {
        //role_id 3 = Content Manager
        return $this->role_id === 6;
    }

    public function isSuscriptorSupport()
    {
        //role_id 3 = Content Manager
        return $this->role_id === 8;
    }

    public function isOnlineSuscriptor()
    {
        //role_id 4 = Suscriptor Online
        return $this->role_id === 4;
    }

    public function isPremium()
    {
        //role_id 2 = Suscripcion Deposito
        return $this->role_id === 2;
    }
      public function isInvitado()
    {
        //role_id 2 = Suscripcion Deposito
        return $this->role_id === 9;
    }
    public function isCliente()
    {
        return $this->role_id === 5;
    }

    public function postClicks()
    {
        return $this->hasMany(PostClick::class);
    }
    public function downloads()
    {
        return $this->hasMany(Download::class);
    }
    public function revistaClicks()
    {
        return $this->hasMany(RevistaClick::class);
    }
    // Chats del usuario
    public function chats()
    {
        return $this->hasMany(Chat::class);
    }

    //  Metodo para mostrar usuaris en linea
    public function isOnline()
    {
        return Cache::has('user-online-'.$this->id);
    }
    public function rolesSuscripcion()
    {
        // 8 = suscription support
        // 6 = suscription manager
        if($this->role_id == 8) return true;
        if($this->role_id == 6) return true;

        return false;
    }

    /*Funcion para recuperar iniciales de usuario*/
    public function getInitials()
    {
        $initials = "";
        if ($this->last_name != null) return $initials = strtoupper(substr($this->name, 0,1).''.substr($this->last_name, 0,1));

        return $initials = strtoupper(substr($this->name, 0,2));

    }
    
    public function countCursos()
    {
         $totalcursos = DB::table('suscriptores_cursos as c')
         ->join('cursos as cu','cu.id','=','c.curso_id')
        ->where('c.user_id','=',$this->id)->where('cu.estado','=','1')->where('cu.expira','>',date('Y-m-d'))->count();
        return $totalcursos;
    }

     public function SuscriptorCursos($cursoid)
    {
        $suscurso = DB::table('suscriptores_cursos as c')
        ->join('cursos as cu','cu.id','=','c.curso_id')
        ->where('c.user_id','=',$this->id)->where('c.curso_id',$cursoid)->where('cu.estado','=','1')->where('cu.expira','>',date('Y-m-d'))->count();
        return $suscurso;
    }


      public function countCursosG()
        {
             $totalcursos = DB::table('suscriptores_cursos as c')
             ->join('cursos as cu','cu.id','=','c.curso_id')
            ->where('c.user_id','=',$this->id)->where('c.compra','=','0')->where('c.suscription_end','>',date('Y-m-d'))->count();
            return $totalcursos;
        }

         public function SuscriptorCursosG($cursoid)
        {
            $suscurso = DB::table('suscriptores_cursos as c')
            ->where('c.user_id','=',$this->id)->where('c.curso_id',$cursoid)->where('c.compra','=','0')->where('c.suscription_end','>',date('Y-m-d'))->count();
            return $suscurso;
        }

    public function SuscriptorCursosC($cursoid)
        {
            $suscurso = DB::table('suscriptores_cursos as c')
            ->where('c.user_id','=',$this->id)->where('c.curso_id',$cursoid)->where('c.suscription_end','>',date('Y-m-d'))->count();
            return $suscurso;
        }


     public function SolicitudCertificado($cursoid)
    {
        $certcurso = DB::table('cursos_certificado as c')
        ->where('c.user_id','=',$this->id)->where('c.curso_id',$cursoid)->count();
        return $certcurso;
    }

     public function ValoracionCurso($cursoid)
    {
        $valcurso = DB::table('cursos_valoraciones as c')
        ->where('c.user_id','=',$this->id)->where('c.curso_id',$cursoid)->count();
        return $valcurso;
    }

     public function InteresCurso($cursoid)
    {
        $interescurso = DB::table('cursos_interes as c')
        ->where('c.user_id','=',$this->id)->where('c.curso_id',$cursoid)->count();
        return $interescurso;
    }

     public function countInteres()
    {
         $totalinteres = DB::table('cursos_interes as c')
         ->join('cursos as cu','cu.id','=','c.curso_id')
        ->where('c.user_id','=',$this->id)->where('cu.estado','=','1')->where('cu.expira','>',date('Y-m-d'))->count();
        return $totalinteres;
    }



    public function countEval()
    {
         $totaleval = DB::table('evaluacion_users as e')
        ->where('e.user_id','=',$this->id)->count();
        return $totaleval;
    }

     public function EvalCursos($evaluacionid)
    {
        $evalcurso = DB::table('evaluacion_users as s')
        ->where('s.user_id','=',$this->id)->where('s.evaluacion_id',$evaluacionid)->count();
        return $evalcurso;
    }

    
      public function countsusgratis()
    {
         $countsusgratis = DB::table('suscriptores_cursos as c')
         ->join('cursos as cu','cu.id','=','c.curso_id')
        ->where('c.user_id','=',$this->id)->where('c.compra','=',0)->count();
        return $countsusgratis;
    }

      public function susplan100r()
    {
         $plan100r = DB::table('suscriptores_recurrente as sr')
        ->where('sr.user_id','=',$this->id)->where('plan_id','=','2')->count();
        return $plan100r;
    }

      public function susplan100d()
    {
         $plan100d = DB::table('suscriptores_deposito as sd')
        ->where('sd.user_id','=',$this->id)->where('plan_id','=','2')->count();
        return $plan100d;
    }

     public function EncuestaCurso($cursoid,$encuestaid)
    {
        $encuestacurso = DB::table('encuestas_curso as c')
         ->join('preguntas_encuestas_curso as pc','pc.encuesta_id','=','c.id')
         ->join('respuestas_preguntas_curso as rp','rp.pregunta_id','=','pc.id')
        ->where('c.id','=',$encuestaid)->where('c.curso_id','=',$cursoid)->where('rp.user_id',Auth()->user()->id)->count();
        return $encuestacurso;
    }
    
    public function socialProfiles()
    {
        return $this->hasMany(SocialProfile::class);
    }
    public function universities()
    {
        return $this->hasMany(University::class);
    }

}
