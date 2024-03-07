<?php

namespace App\Http\Controllers;

use App\Permiso;
use App\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Role::where('grupo','=','panel')->get();
        return view('panel.role.index',compact('roles'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $permisos = Permiso::all();
        $role = Role::find($id);
        return view('panel.role.permisos',compact('role','permisos'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    // quitar o asignar permisos de un ROL
    public function auditPermiso(Request $request,$id)
    {
        $role = Role::find($id);
        //quitar todos los permiso del rol
        $role->permisos()->detach();

        if ($request->permisos) {
            foreach ($request->permisos as $perm_id) {
                $role->permisos()->attach($perm_id);
            }
        }

        return back()->with('msg','¡Actulización exitosa!');
    }
}
