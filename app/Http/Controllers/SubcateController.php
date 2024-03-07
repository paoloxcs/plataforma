<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Subcategoria;
use App\Categoria;
use Session;
use Redirect;
class SubcateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($categ_id)
    {
        $categoria = Categoria::find($categ_id);
        return view('panel.subcate.index',compact('categoria'));
    }
    public function getSubcates(Request $request)
    {
        $subcates = Subcategoria::where('idcategoria',$request->categid)->with('posts')->orderBy('idsubcategoria','desc')->paginate(6);
        return response()->json($subcates);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categorias = Categoria::all();
        return view('panel.subcate.create',compact('categorias'));
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
            'nombresubcategoria'=>'required|unique:subcategoria,nombresubcategoria,'.$request->nombresubcategoria.',idsubcategoria,idcategoria,'.$request->idcategoria
            ],[
                'nombresubcategoria.required' => 'Ingrese nombre de subcategoría',
                'nombresubcategoria.unique'=>'La subcategoría '.$request->nombresubcategoria.' ya existe!'
            ]);
        if ($validation->fails()) {
            return response()->json(['errors' => $validation->errors(),'status' => 422]);
        }else{

            $slug = create_slug($request->nombresubcategoria).'-'.uniqid();
            $subcate = Subcategoria::create([
                'nombresubcategoria'=>$request->nombresubcategoria,
                'slug'=>$slug,
                'idcategoria'=>$request->idcategoria
            ]);

            return response()->json(['message' => 'Registro exitoso!','status' => 200]);
        }
        
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
        $categorias = Categoria::all();
        $subcate = Subcategoria::find($id);
        return view('panel.subcate.edit',compact('categorias','subcate'));
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
            'nombresubcategoria'=>'required|unique:subcategoria,nombresubcategoria,'.$id.',idsubcategoria,idcategoria,'.$request->idcategoria
            ],[
                'nombresubcategoria.required' => 'Ingrese nombre de subcategoría',
                'nombresubcategoria.unique' => 'La subcategoría '.$request->nombresubcategoria.' ya existe!'
            ]);
        if($validation->fails()){
            return response()->json(['errors' => $validation->errors(),'status' => 422]);
        }else{

            $slug = create_slug($request->nombresubcategoria).'-'.uniqid();

            $subcate = Subcategoria::find($id);
            $subcate->nombresubcategoria = $request->nombresubcategoria;
            $subcate->slug = $slug;
            $subcate->save();

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
        $subcate = Subcategoria::find($id);
        $subcate->delete();
    
        return response()->json(['message'=>'Registro borrado con éxito']);
        } catch (Exception $e) {
            dd($e);
        }
        
    }
}
