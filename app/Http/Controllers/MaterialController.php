<?php

namespace App\Http\Controllers;
use Session;
use App\Curso;
use App\Material;
use Illuminate\Http\Request;

function create_slug($string, $replace = array(), $delimiter = '-'){
    // Validacion de acotejamiento utf-8
    if (!extension_loaded('iconv')) {
      throw new Exception('iconv module not loaded');
    }
    // Obtener cotejamiento por defecto y pasar a UTF-8
    $oldLocale = setlocale(LC_ALL, '0');
    setlocale(LC_ALL, 'en_US.UTF-8');
    $clean = iconv('UTF-8', 'ASCII//TRANSLIT', $string);
    if (!empty($replace)) {
      $clean = str_replace((array) $replace, ' ', $clean);
    }
    $clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $clean);
    $clean = strtolower($clean);
    $clean = preg_replace("/[\/_|+ -]+/", $delimiter, $clean);
    $clean = trim($clean, $delimiter);
    // Revert back to the old locale
    setlocale(LC_ALL, $oldLocale);
    //Concatenando con el time
    return $clean;
}



class MaterialController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $materiales = Material::paginate(8);
        return view('panel.material.index',compact('materiales'));
        
    }

     public function material($id)
    {
        $materiales = Material::where('curso_id','=',$id)->paginate(8);
        $curso = Curso::where('id','=',$id)->first();
        return view('panel.material.index',compact('materiales','curso'));
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request){
           $validation = \Validator::make($request->all(),[
            'nombre' => 'required|string',
            
            'file' => 'required|file',

            ]);
            if($validation->fails()){
            return response()->json(['errors' => $validation->errors()], 422);
            }

            $nompdf =uniqid().'.'.$request->file('file')->getClientOriginalExtension();
            $request->file('file')->move(public_path().'/pdfCurso/',$nompdf);

            $peso=$request->file('file')->getClientSize();

            
                      
                $material = new Material();
                $material->nombre_documento = $request->nombre;
                $material->peso = round($peso/1000).' Kb';
                $material->url_file =$nompdf;
                $material->tipo=$request->file('file')->getClientOriginalExtension();
                $material->curso_id = $request->curso_id;
                $material->slug= create_slug($request->titulo).'-'.uniqid();
               
                $material->save();
              
            


      Session::flash('msg','¡Registro exitoso!');
       return redirect('panel/curso/materiales/'.$request->curso_id);
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
        $material = Material::find($id);
       
        return view('panel.material.edit',compact('material'));
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
            'nombre' => 'required|string'  
            ]);

        if ($validation->fails()) {
            return response()->json(['errors' => $validation->errors()], 422);
        }

        $material = Material::find($id);
        //actualizamos el slug
        if ($request->nombre !=$material->nombre_documento) {
            $material->nombre_documento = $request->nombre;
            $material->slug = create_slug($request->nombre).'-'.uniqid();
        }




        if ($request->file('file')) {
             $validation = \Validator::make($request->all(),[
                'file' => 'required|mimes:pdf'
            ]);
             //Borramos el archivo anterior si existe
             if(file_exists(public_path().'/pdfCurso/'.$material->url_file)){
                 unlink(public_path().'/pdfCurso/'.$material->url_file);
                 $peso=$request->file('file')->getClientSize();
                 $material->peso=round($peso/1000).' Kb';
                 $material->tipo=$request->file('file')->getClientOriginalExtension();
             }

             $nompdf = uniqid().'.'.$request->file('file')->getClientOriginalExtension();
             $request->file('file')->move(public_path().'/pdfCurso/',$nompdf);
             $material->url_file=$nompdf;

         }

        $material->save();

        return redirect('panel/curso/materiales/'.$material->curso_id);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $material = Material::find($id);

        $material->delete();

        Session::flash('msg','¡Se eliminó un registro!');
        return redirect(url()->previous());
    }

    public function buscador(Request $request){
        $cursos=Curso::where("titulo",'like',"%".$request->texto."%")->orWhere("descripcion",'like',"%".$request->texto."%")->orWhere("informacion",'like',"%".$request->texto."%")->orWhere("precio",'like',"%".$request->texto."%")->orWhere("promocion",'like',"%".$request->texto."%")->orWhere("fecha",'like',"%".$request->texto."%")->orderBy('titulo','Asc')->limit(8)->get();

        return view('panel.curso.buscador',compact('cursos'));
    }
   
}
