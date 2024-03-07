<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Categoria;
use App\Rubro;
class CategoriaController extends Controller
{
    /**
     * @return \Illuminate\Http\Response
     */
    public function index($rub_id)
    {
        // Retorna la vista para lista categorias del rubro elegido.
        $rubro = Rubro::find($rub_id);
        return view('panel.categoria.index',compact('rubro'));
    }

    public function getCategorias(Request $request)
    {
        // Retorna lista paginada de categorias del rubro elegido en formato JSON.
        $categorias = Categoria::where('idrubro',$request->rubroid)->with('subcategorias')->orderBy('idcategoria','desc')->paginate(6);
        return response()->json($categorias);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validation = \Validator::make($request->all(),[
            'nombrecategoria'=>'required|unique:categoria,nombrecategoria,'.$request->nombrecategoria.',idcategoria,idrubro,'.$request->idrubro
            ],[
            'nombrecategoria.required' => 'Ingrese nombre de categoría',
            'nombrecategoria.unique' => 'La categoría '.$request->nombrecategoria.' ya existe!'
            ]);
        
        if ($validation->fails()) {
            return response()->json(['errors' => $validation->errors(),'status' => 422]);
        }else{

            $slug = create_slug($request->nombrecategoria).'-'.uniqid();

            Categoria::create([
                'nombrecategoria'=>$request->nombrecategoria,
                'slug'           =>$slug,
                'idrubro'        =>$request->idrubro
            ]);

            return response()->json(['message' => 'Registro exitoso!','status' => 200]);
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
            'nombrecategoria'=>'required|unique:categoria,nombrecategoria,'.$id.',idcategoria,idrubro,'.$request->idrubro
            ],[
                'nombrecategoria.required' => 'Ingrese nombre de categoría',
                'nombrecategoria.unique' => 'La categoría '.$request->nombrecategoria.' ya existe!'
            ]);
        if ($validation->fails()) {
            return response()->json(['errors' => $validation->errors(),'status' => 422]);

        }else{
            $slug = create_slug($request->nombrecategoria).'-'.uniqid();

            $categoria = Categoria::find($id);
            $categoria->nombrecategoria =$request->nombrecategoria;
            $categoria->slug = $slug;
            $categoria->save();

            return response()->json(['message' => 'Actualización exitosa!','status' => 200]);
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
        $categoria = Categoria::find($id);
        $categoria->delete();

        return response()->json(['message'=>'Registro eliminado con éxito']);
        
        } catch (Exception $e) {
           dd($e); 
        }
       
    }
}
