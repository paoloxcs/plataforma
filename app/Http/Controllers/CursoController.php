<?php

namespace App\Http\Controllers;
use Session;
use App\Curso;
use App\Rubro;
use App\Autor;
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



class CursoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         // $cursos = Curso::orderBy('id','desc')->paginate(8);
 
       // return view('panel.curso.index_v1');
        //Version 1
        $cursos_query =   Curso::when(request('order') ?? 'new', function ($query, $order) {
            $sort = $order === 'new' ? 'desc' : 'asc';
            $query->orderBy('fecha',  $sort);
        })->when(request('r') ?? null, function ($query, $rubro) {
            $query->where('rubro_id', $rubro);
        })->when(request('search') ?? null, function ($query, $buscar) {
            $query->where(function ($query) use ($buscar) {
                $query->where("titulo", 'like', "%" . $buscar . '%')
                    ->orWhere('descripcion', 'like', '%' . $buscar . '%')
                    ->orWhere('informacion', 'like', '%' . $buscar . '%')
                    ->orWhere('precio', 'like', '%' . $buscar . '%')
                    ->orWhere('promocion', 'like', '%' . $buscar . '%');
            }); 
        });

        // $cursos = $coursesQuery->orderBy('id',  'desc')->paginate(8);
        $cursos = $cursos_query->orderBy('id',  'desc')->paginate(8);
        $cursos_count = $cursos_query->count();

        if (request('count_curso')) {
            $cursos_count = request('count_curso');
        }

        $rubros = Rubro::orderBy('nombrerubro', 'Asc')->get();
        $autores = Autor::orderBy('nombre', 'Asc')->get();
        return view('panel.curso.index', compact('cursos', 'cursos_count', 'rubros', 'autores'));
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
            'titulo' => 'required|string',
            'descripcion' => 'required|string',
            'informacion' => 'required|string',
            'rubro_id' => 'required|string',
            'autor_id' => 'required|string',
            'precio' => 'required|numeric',
            'promocion' => 'required|numeric',
            'precio_d' => 'required|numeric',
            'promocion_d' => 'required|numeric',
            'estado' => 'required|string',
            'fecha' => 'required|date',
            'time' => 'required',
            'expira' => 'required|date',
            'fecha_culminacion' => 'required|date',
            'portada' => 'required|mimes:jpg,png,jpeg|max:100',
            'banner_portada' => 'required|mimes:jpg,png,jpeg|max:100',
            'banner_descripcion' => 'required|string',
            'beneficios' => 'required|string'
           
            ]);
            if($validation->fails()){
            return response()->json(['errors' => $validation->errors()], 422);
            }
            //Recuperando la extension de la imagen
            $extension =$request->file('portada')->getClientOriginalExtension();
            $imgnombre= uniqid().'.'.$extension;

             $extension1 =$request->file('banner_portada')->getClientOriginalExtension();
            $imgnombre1= uniqid().'.'.$extension1;

        

            if ($request->file('portada')->move(public_path().'/imgCurso/',$imgnombre)) {

              $curso = new Curso();

               if ($request->file('banner_portada')->move(public_path().'/imgCurso/',$imgnombre1)) { 
                  $curso->banner_portada=$imgnombre1;
                $curso->banner_descripcion=$request->banner_descripcion;
               }     


              if ($request->file('certificado')) {
                  $validation = \Validator::make($request->all(),[
                      'certificado'   =>  'mimes:jpg,png,jpeg|max:100'
                  ]);

                  if($validation->fails()){
                      return response()->json(['errors' => $validation->errors()], 422);
                  }
                  //Borramos el archivo anterior
                  if($curso->certificado && file_exists(public_path().'/imgCurso/'.$curso->certificado)){
                     unlink(public_path().'/imgCurso/'.$curso->certificado);
                  }
                  //Recuperando la extension de la imagen
                  $extension2 =$request->file('certificado')->getClientOriginalExtension();
                  $imgnombre2= uniqid().'.'.$extension2;
                  if ($request->file('certificado')->move(public_path().'/imgCurso/')->move(public_path().'/imgCurso/',$imgnombre2)) {
                      $curso->certificado = $imgnombre2;
                  }
               } 

                
                $curso->titulo = $request->titulo;
                $curso->descripcion = $request->descripcion;
                $curso->objetivos = $request->objetivos;
                $curso->publico = $request->publico;
                $curso->informacion = $request->informacion;
                $curso->url_portada = $imgnombre;
                $curso->precio = $request->precio;
                $curso->promocion = $request->promocion;
                $curso->precio_d = $request->precio_d;
                $curso->promocion_d = $request->promocion_d;
                $curso->precio_c = $request->precio_c;
                $curso->promocion_c = $request->promocion_c;
                $curso->estado = $request->estado;
                $curso->fecha = $request->fecha;
                $curso->time = $request->time;
                $curso->expira = $request->expira;
                $curso->url_video_preview = $request->url_video_preview;
                $curso->fecha_culminacion = $request->fecha_culminacion;
                 $curso->slug= create_slug($request->titulo).'-'.uniqid();
                $curso->rubro_id = $request->rubro_id;
                $curso->autor_id = $request->autor_id;
                
                $curso->beneficios=$request->beneficios;

                $curso->fecha_d_v=$request->fecha_d_v;
                $curso->porcentaje_d_v=$request->porcentaje_d_v;
               
                $curso->save();
               

             }  
           
             

      Session::flash('msg','¡Registro exitoso!');
       return redirect()->route('cursos');
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
        $curso = Curso::find($id);
        $rubros = Rubro::orderBy('nombrerubro','Asc')->get();
        $autores=Autor::orderBy('nombre','Asc')->get();
        return view('panel.curso.edit',compact('curso','rubros','autores'));
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
            'titulo' => 'required|string',
            'descripcion' => 'required|string',
            'informacion' => 'required|string',
            'rubro_id' => 'required|string',
            'autor_id' => 'required|string',
            'precio' => 'required|numeric',
            'promocion' => 'required|numeric',
            'precio_d' => 'required|numeric',
            'promocion_d' => 'required|numeric',
            'estado' => 'required|string',
            'fecha' => 'required|date',
            'time' => 'required',
            'expira' => 'required|date',
            'fecha_culminacion' => 'required|date',
            'banner_descripcion' => 'required|string',
            'beneficios' => 'required|string'
            
           
            ]);

        if ($validation->fails()) {
            return response()->json(['errors' => $validation->errors()], 422);
        }

        $curso = Curso::find($id);
        //actualizamos el slug
        if ($request->titulo !=$curso->titulo) {
            $curso->titulo = $request->titulo;
            $curso->slug = create_slug($request->titulo).'-'.uniqid();
        }

         if ($request->file('portada')) {
            $validation = \Validator::make($request->all(),[
                'portada'   =>  'mimes:jpg,png,jpeg|max:100'
            ]);

            if($validation->fails()){
                return response()->json(['errors' => $validation->errors()], 422);
            }
            //Borramos el archivo anterior
            if($curso->url_portada && file_exists(public_path().'/imgCurso/'.$curso->url_portada)){
               unlink(public_path().'/imgCurso/'.$curso->url_portada);
            }
            //Recuperando la extension de la imagen
            $extension =$request->file('portada')->getClientOriginalExtension();
            $imgnombre= uniqid().'.'.$extension;
            if ($request->file('portada')->move(public_path().'/imgCurso/',$imgnombre)) {
                $curso->url_portada = $imgnombre;
            }
        }


         if ($request->file('banner_portada')) {
            $validation = \Validator::make($request->all(),[
                'banner_portada'   =>  'mimes:jpg,png,jpeg|max:100'
            ]);

            if($validation->fails()){
                return response()->json(['errors' => $validation->errors()], 422);
            }
            //Borramos el archivo anterior
            if($curso->banner_portada && file_exists(public_path().'/imgCurso/'.$curso->banner_portada)){
               unlink(public_path().'/imgCurso/'.$curso->banner_portada);
            }
            //Recuperando la extension de la imagen
            $extension1 =$request->file('banner_portada')->getClientOriginalExtension();
            $imgnombre1= uniqid().'.'.$extension1;
            if ($request->file('banner_portada')->move(public_path().'/imgCurso/',$imgnombre1)) {
                $curso->banner_portada = $imgnombre1;
            }

            }

        if ($request->file('certificado')) {
            $validation = \Validator::make($request->all(),[
                'certificado'   =>  'mimes:jpg,png,jpeg|max:100'
            ]);

            if($validation->fails()){
                return response()->json(['errors' => $validation->errors()], 422);
            }
            //Borramos el archivo anterior
            if($curso->certificado && file_exists(public_path().'/imgCurso/'.$curso->certificado)){
               unlink(public_path().'/imgCurso/'.$curso->certificado);
            }
            //Recuperando la extension de la imagen
            $extension2 =$request->file('certificado')->getClientOriginalExtension();
            $imgnombre2= uniqid().'.'.$extension2;
            if ($request->file('certificado')->move(public_path().'/imgCurso/')->move(public_path().'/imgCurso/',$imgnombre2)) {
                $curso->certificado = $imgnombre2;
            }
        }

                
        $curso->descripcion = $request->descripcion;
        $curso->objetivos = $request->objetivos;
        $curso->publico = $request->publico;
        $curso->informacion = $request->informacion;
        $curso->banner_descripcion = $request->banner_descripcion;
        $curso->precio = $request->precio;
        $curso->promocion = $request->promocion;
        $curso->precio_d = $request->precio_d;
        $curso->promocion_d = $request->promocion_d;
        $curso->precio_c = $request->precio_c;
        $curso->promocion_c = $request->promocion_c;
        $curso->estado = $request->estado;
        $curso->fecha = $request->fecha;
        $curso->time = $request->time;
        $curso->expira = $request->expira;
        $curso->url_video_preview = $request->url_video_preview;
        $curso->fecha_culminacion = $request->fecha_culminacion;
        $curso->rubro_id = $request->rubro_id;
        $curso->autor_id = $request->autor_id;
        $curso->beneficios = $request->beneficios;
        $curso->fecha_d_v=$request->fecha_d_v;
                $curso->porcentaje_d_v=$request->porcentaje_d_v;
        $curso->save();

        return redirect()->route('cursos');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $curso = Curso::find($id);

        $curso->delete();

        Session::flash('msg','¡Se eliminó un registro!');
        return redirect()->route('cursos');
    }

    public function buscador(Request $request){
        $cursos=Curso::where("titulo",'like',"%".$request->texto."%")->orWhere("descripcion",'like',"%".$request->texto."%")->orWhere("informacion",'like',"%".$request->texto."%")->orWhere("precio",'like',"%".$request->texto."%")->orWhere("promocion",'like',"%".$request->texto."%")->orWhere("fecha",'like',"%".$request->texto."%")->orderBy('titulo','Asc')->limit(8)->get();

        return view('panel.curso.buscador',compact('cursos'));
    }
   
}

