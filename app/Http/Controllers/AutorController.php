<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Autor;
class AutorController extends Controller
{
    public function index()
    {
        /* Retorna la vista vacia para listar los autores */
        return view('panel.autor.index');
    }

    public function getAutor($id)
    {
        $autor = Autor::find($id);
        return response()->json($autor);
    }

    public function getAutores(Request $request)
    {
        /* Retorna lista de Autores con paginacion en formato JSON */
        $autores = Autor::orderBy('idautor','desc')->paginate(4);
        return response()->json($autores);
    }

    public function buscador(Request $request)
    {
        /* Retorna lista de Autores con paginacion en formato JSON */
        $autores = Autor::
        where("nombre",'like',"%".$request->texto."%")
        ->orWhere("bio",'like',"%".$request->texto."%")
        ->orWhere("nacionalidad",'like',"%".$request->texto."%")
        ->orderBy('nombre','asc')->limit(4)->get();

        return view('panel.autor.buscador',compact('autores'));
    }



    public function getAutorsAll()
    {
        /* Retorna lista completa de Autores en formato JSON */
        $autores = Autor::orderBy('idautor','desc')->get();
        return response()->json($autores);
    }
    /**
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        /* Validación de antes de insertar a la base de datos */
        $validation = \Validator::make($request->all(),[
        'nombre'=>'required|unique:autor',
        'bio'=>'required',
        'pais'=>'required',
        'cargo'=>'required',
        'imagen'=>'required|mimes:jpeg,jpg,png| max:50'
        ]);

        // Si la validacion falla, devuelve los errores en formato JSON y asu vez envia un status code
        if ($validation->fails()) {
            return response()->json(['errors'=>$validation->errors(),'status'=> 422]);
        }else{
            //Obtiene la extension del archivo y concate con un uniqid
            $imgnombre= uniqid().'.'.$request->file('imagen')->getClientOriginalExtension();
            // Mueve el archivo a la carpeta publica "posts"
            $request->file('imagen')->move(public_path().'/posts/',$imgnombre);
            // Crea slug a partir del nombre del autor
            $slug = create_slug($request->nombre);

            // Crea una instacia del Modelo Autor y asigna los parametros del request
            $autor = new Autor();
            $autor->nombre= $request->nombre;
            $autor->slug = $slug;
            $autor->bio=$request->bio;
            $autor->nacionalidad =$request->pais;
            $autor->cargo=$request->cargo;
            $autor->principal =$request->principal;
            $autor->imagen=$imgnombre;

            $autor->save(); // Guarda en la base de datos
            create_user_log('Agregó el autor: '.strtoupper($autor->nombre));
            // Devuelve un mensaje de exito y asu vez un status code
            return response()->json(['message'=>'Registro exitoso!', 'status'=>200]);
        }     
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
        $validation = \Validator::make($request->all(),[
            'nombre'=>'required|unique:autor,nombre,'.$id.',idautor',
            'bioedit'=>'required',
            'pais'=>'required',
            'cargo'=>'required'
            ]);

        if($validation->fails()){
            return response()->json(['errors' => $validation->errors(),'status'=>422]);
        }else{

            $autor = Autor::find($id);

            if ($request->file('imagen')) {

                if(file_exists(public_path().'/posts/'.$autor->imagen)){
                  unlink(public_path().'/posts/'.$autor->imagen);
                }
                //obtener nombre de la imagen y concatenar con el time
                $imgnombre =uniqid().'.'.$request->file('imagen')->getClientOriginalExtension();
                $request->file('imagen')->move(public_path().'/posts/',$imgnombre);
                $autor->imagen =$imgnombre;

            }

            if ($request->nombre != $autor->nombre) {
                $slug = create_slug($request->nombre);
                $autor->nombre = $request->nombre;
                $autor->slug = $slug;
            }
             
             $autor->bio=$request->bioedit;
             $autor->nacionalidad = $request->pais;

            $autor->cargo=$request->cargo;
            $autor->principal =$request->principal;
             $autor->save();

             create_user_log('Actualizó los datos del autor: '.strtoupper($autor->nombre));

             return response()->json(['message'=>'Actualizacion exitosa!','status'=>200]);
            
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
        $autor = Autor::find($id);
        //Borrando la foto del autor
        if(file_exists(public_path().'/posts/'.$autor->imagen)){
            unlink(public_path().'/posts/'.$autor->imagen);
        }
        create_user_log('Eliminó el autor: '.strtoupper($autor->nombre));
        
        $autor->delete();
        //Mensaje de respuesta en formato JSON
        return response()->json(['message'=>'Registro eliminado!','status' => 200]);
        } catch (Exception $e) {
            dd($e);
        }
        
    }
}
