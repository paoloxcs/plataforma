<?php

namespace App\Http\Controllers;

use App\Asignacion;
use App\Role;
use App\User;
use App\SocialProfile;
use Illuminate\Http\Request;
use Session;
use DB;
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Retorna lista de usuarios que pertenezca al grupo panel
        $users = User::join('roles as r','users.role_id','=','r.id')->where('r.grupo','=','panel')
        ->select('users.id','users.name','users.last_name','email','r.name as role')
        ->orderBy('users.id','desc')->paginate(10);

        return view('panel.user.index',compact('users'));
    }

    public function getOnline()
    {
        // Retorna tolos usuario que estan en linea
        $users = User::all();
        return view('panel.user.online',compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::where('grupo','=','panel')->get();
        return view('panel.user.create',compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'name'      =>  'required|string|max:45',
            'last_name' =>  'required|string|max:45',
            'email'     =>  'required|string|email|max:100|unique:users',
            'password'  =>  'required|string|min:6|confirmed',
        ]);

        $user = User::create([
            'name'      =>  $request->name,
            'last_name' =>  $request->last_name,
            'email'     =>  $request->email,
            'password'  =>  bcrypt($request->password),
            'role_id'   =>  $request->role
        ]);


        create_user_log('Agregó a '.$user->fullName().' ('.$user->role->name.')');

        Session::flash('msg','El registro se guardó con éxtio!');
        return redirect()->route('users.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $roles = Role::where('grupo','=','panel')->get();
        $user = User::find($id);

        return view('panel.user.edit',compact('roles','user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request,[
            'name' => 'required|string|max:255',
            'last_name'=>'required|string|max:255',
            'email' => 'required|string|email|unique:users,email,'.$id.',id',
            ]);

        $user = User::find($id);

        $user->name = $request->name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        $user->role_id = $request->role;
        $user->save();

        create_user_log('Actualizó los datos de '.$user->fullName().' ('.$user->role->name.')');

        Session::flash('msg','El registro fue actualizado con éxito');

        return redirect()->route('users.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
        create_user_log('Eliminó a '.$user->fullName().' ('.$user->role->name.')');
        $user->delete();

        Session::flash('msg','El registro fue eliminado con éxito');

        return redirect()->route('users.index');
    }
    
    public function destroyByAjax($id) // Elimina un usuario mediante peticion ajax
    {
        $user = User::find($id);
        if ($user->url_foto != null && file_exists(public_path().'/fotousers/'.$user->url_foto)) {
            unlink(public_path().'/fotousers/'.$user->url_foto);
        }
         //Delete Social Profile
        if ($user->socialProfiles != '[]') {
            $socialProfiles = SocialProfile::where('user_id', $user->id)->get();
            foreach ($socialProfiles as $socialProfile) {
                $socialProfile->delete();
            }
        }
        create_user_log('Eliminó a '.$user->fullName().' ('.$user->role->name.')');
        
        $user->delete();
        return response()->json(['message'=>'El registro fue eliminado'], 200);
    }

    public function getAsesores()
    {
        $users = User::where('role_id',8)->orWhere('role_id',6)->get();
        return response()->json($users);
    }

    public function asignationsView()
    {
        return view('panel.user.mibandeja');
    }

    public function getAsignations()
    {
        $asignations = Asignacion::where([['gestor_id',Auth()->user()->id],['is_confirmed',false]])->with('suscriptor.intereses.medio')->orderBy('id','DESC')->paginate(6); // Lista las asignaciones para el usuario autenticado con el rol "soporte de suscripcion"
        return response()->json($asignations);
        
    }

    public function searchAsignations($text)
    {
        $asignations = Asignacion::join('users as u','u.id','=','asignaciones.suscriptor_id')
        ->where([[DB::raw('concat(u.name," ",u.last_name)'),'like','%'.$text.'%'],['asignaciones.gestor_id',Auth()->user()->id],['asignaciones.is_confirmed', false]])
        ->orWhere([['u.email', 'like', '%'.$text.'%'],['asignaciones.gestor_id',Auth()->user()->id],['asignaciones.is_confirmed', false]])
        ->select('asignaciones.*')->with('suscriptor.intereses.medio')
        ->limit(6)
        ->get();
        return response()->json($asignations);
    }
    
}
