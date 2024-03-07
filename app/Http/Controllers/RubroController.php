<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Rubro;
use App\Slider_Rubro;
use Session;
use Redirect;
use DB;
class RubroController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('panel.rubro.index');
    }
    public function getRubros(Request $request)
    {
        $rubros = Rubro::orderBy('idrubro','desc')->with('categorias')->paginate(6);
        return response()->json($rubros);
    }
    public function getRubrosAll()
    {
        $rubros = Rubro::all();
        return response()->json($rubros);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('panel.rubro.create');
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
            'nombrerubro'=>'required|unique:rubro',
            'estado' => 'required|string',
            'img_curso' => 'required|mimes:jpg,png,jpeg|max:100',
            'img_capacitacion' => 'required|mimes:jpg,png,jpeg|max:100',
            'img_revista' => 'required|mimes:jpg,png,jpeg|max:100',
            'img_articulo' => 'required|mimes:jpg,png,jpeg|max:100',
            'img_beneficio' => 'required|mimes:jpg,png,jpeg|max:100',
        ],[
            'nombrerubro.required' => 'Ingrese nombre de rubro',
            'nombrerubro.unique' => 'El rubro '.$request->nombrerubro.' ya existe!'
        ]);

       if ($validation->fails()) {
            return response()->json(['errors'=>$validation->errors(),'status'=> 422]);
        }

        //Recuperando la extension de la imagen
            $extension =$request->file('img_curso')->getClientOriginalExtension();
            $img_curso= uniqid().'.'.$extension;

            $extension1 =$request->file('img_capacitacion')->getClientOriginalExtension();
            $img_capacitacion= uniqid().'.'.$extension1;

            $extension2 =$request->file('img_revista')->getClientOriginalExtension();
            $img_revista= uniqid().'.'.$extension2;

            $extension3 =$request->file('img_articulo')->getClientOriginalExtension();
            $img_articulo= uniqid().'.'.$extension3;

            $extension4 =$request->file('img_beneficio')->getClientOriginalExtension();
            $img_beneficio= uniqid().'.'.$extension4;

           


       
        $slug = create_slug($request->nombrerubro);

        $rubro = new Rubro();

        if ($request->file('img_curso')->move(public_path().'/imgRubro/',$img_curso)) {  
        $rubro->img_curso=$img_curso;
        }

        if ($request->file('img_capacitacion')->move(public_path().'/imgRubro/',$img_capacitacion)) {  
        $rubro->img_capacitacion=$img_capacitacion;
        }

        if ($request->file('img_revista')->move(public_path().'/imgRubro/',$img_revista)) {  
        $rubro->img_revista=$img_revista;
        }

        if ($request->file('img_articulo')->move(public_path().'/imgRubro/',$img_articulo)) {  
        $rubro->img_articulo=$img_articulo;
        }

        

        if ($request->file('img_beneficio')->move(public_path().'/imgRubro/',$img_beneficio)) {  
        $rubro->img_beneficio=$img_beneficio;
        }

        if ($request->file('img_suplemento')) {
                $validation = \Validator::make($request->all(),[
                    'img_suplemento'   =>  'mimes:jpg,png,jpeg|max:100'
                ]);

                if($validation->fails()){
                    return response()->json(['errors' => $validation->errors()], 422);
                }
                

                $extension5 =$request->file('img_suplemento')->getClientOriginalExtension();
                $img_suplemento= uniqid().'.'.$extension5;
                if ($request->file('img_suplemento')->move(public_path().'/imgRubro/',$img_suplemento)) {  
                        $rubro->img_suplemento=$img_suplemento;
                }
        }

        $rubro->estado = $request->estado;
        $rubro->nombrerubro=$request->nombrerubro;
        $rubro->slug = $slug;
        $rubro->save();

        return response()->json(['message'=>'Registro exitoso!','status'=>200]);

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
        $rubro = Rubro::find($id);
        
        return view('panel.rubro.edit',compact('rubro'));
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
                'nombrerubro'=>'required|unique:rubro,nombrerubro,'.$id.',idrubro'
            ],[
                'nombrerubro.required' => 'Ingrese nombre de rubro',
                'nombrerubro.unique' => 'El '.$request->nombrerubro.' ya existe!'
            ]);

        if ($validation->fails()) {
            return response()->json(['errors' => $validation->errors(),'status' => 422]);
        }else{

            $slug = create_slug($request->nombrerubro);

            $rubro = Rubro::find($id);

            if ($request->file('img_curso')) {
                $validation = \Validator::make($request->all(),[
                    'img_curso'   =>  'mimes:jpg,png,jpeg|max:100'
                ]);

                if($validation->fails()){
                    return response()->json(['errors' => $validation->errors()], 422);
                }
                //Borramos el archivo anterior
                if($rubro->img_curso && file_exists(public_path().'/imgRubro/'.$rubro->img_curso)){
                   unlink(public_path().'/imgRubro/'.$rubro->img_curso);
                }

                $extension =$request->file('img_curso')->getClientOriginalExtension();
                $img_curso= uniqid().'.'.$extension;
                if ($request->file('img_curso')->move(public_path().'/imgRubro/',$img_curso)) {  
                        $rubro->img_curso=$img_curso;
                }
            }

            if ($request->file('img_capacitacion')) {
                $validation = \Validator::make($request->all(),[
                    'img_capacitacion'   =>  'mimes:jpg,png,jpeg|max:100'
                ]);

                if($validation->fails()){
                    return response()->json(['errors' => $validation->errors()], 422);
                }
                //Borramos el archivo anterior
                if($rubro->img_capacitacion && file_exists(public_path().'/imgRubro/'.$rubro->img_capacitacion)){
                   unlink(public_path().'/imgRubro/'.$rubro->img_capacitacion);
                }

                $extension1 =$request->file('img_capacitacion')->getClientOriginalExtension();
                $img_capacitacion= uniqid().'.'.$extension1;
                if ($request->file('img_capacitacion')->move(public_path().'/imgRubro/',$img_capacitacion)) {  
                        $rubro->img_capacitacion=$img_capacitacion;
                }
            }

            if ($request->file('img_revista')) {
                $validation = \Validator::make($request->all(),[
                    'img_revista'   =>  'mimes:jpg,png,jpeg|max:100'
                ]);

                if($validation->fails()){
                    return response()->json(['errors' => $validation->errors()], 422);
                }
                //Borramos el archivo anterior
                if($rubro->img_revista && file_exists(public_path().'/imgRubro/'.$rubro->img_revista)){
                   unlink(public_path().'/imgRubro/'.$rubro->img_revista);
                }

                $extension2 =$request->file('img_revista')->getClientOriginalExtension();
                $img_revista= uniqid().'.'.$extension2;
                if ($request->file('img_revista')->move(public_path().'/imgRubro/',$img_revista)) {  
                        $rubro->img_revista=$img_revista;
                }
            }

            if ($request->file('img_articulo')) {
                $validation = \Validator::make($request->all(),[
                    'img_articulo'   =>  'mimes:jpg,png,jpeg|max:100'
                ]);

                if($validation->fails()){
                    return response()->json(['errors' => $validation->errors()], 422);
                }
                //Borramos el archivo anterior
                if($rubro->img_articulo && file_exists(public_path().'/imgRubro/'.$rubro->img_articulo)){
                   unlink(public_path().'/imgRubro/'.$rubro->img_articulo);
                }

                $extension3 =$request->file('img_articulo')->getClientOriginalExtension();
                $img_articulo= uniqid().'.'.$extension3;
                if ($request->file('img_articulo')->move(public_path().'/imgRubro/',$img_articulo)) {  
                        $rubro->img_articulo=$img_articulo;
                }
            }

            if ($request->file('img_suplemento')) {
                $validation = \Validator::make($request->all(),[
                    'img_suplemento'   =>  'mimes:jpg,png,jpeg|max:100'
                ]);

                if($validation->fails()){
                    return response()->json(['errors' => $validation->errors()], 422);
                }
                //Borramos el archivo anterior
                if($rubro->img_suplemento && file_exists(public_path().'/imgRubro/'.$rubro->img_suplemento)){
                   unlink(public_path().'/imgRubro/'.$rubro->img_suplemento);
                }

                $extension4 =$request->file('img_suplemento')->getClientOriginalExtension();
                $img_suplemento= uniqid().'.'.$extension4;
                if ($request->file('img_suplemento')->move(public_path().'/imgRubro/',$img_suplemento)) {  
                        $rubro->img_suplemento=$img_suplemento;
                }
            }

            if ($request->file('img_beneficio')) {
                $validation = \Validator::make($request->all(),[
                    'img_beneficio'   =>  'mimes:jpg,png,jpeg|max:100'
                ]);

                if($validation->fails()){
                    return response()->json(['errors' => $validation->errors()], 422);
                }
                //Borramos el archivo anterior
                if($rubro->img_beneficio && file_exists(public_path().'/imgRubro/'.$rubro->img_beneficio)){
                   unlink(public_path().'/imgRubro/'.$rubro->img_beneficio);
                }

                $extension5 =$request->file('img_beneficio')->getClientOriginalExtension();
                $img_beneficio= uniqid().'.'.$extension5;
                if ($request->file('img_beneficio')->move(public_path().'/imgRubro/',$img_beneficio)) {  
                        $rubro->img_beneficio=$img_beneficio;
                }
            }



            $rubro->estado = $request->estado;
            $rubro->nombrerubro = $request->nombrerubro;
            $rubro->slug = $slug;
            $rubro->save();

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
        $rubro = Rubro::find($id);
        $rubro->delete();
        return response()->json(['message'=>'Registro borrado con éxito']);

        } catch (Exception $e) {
            dd($e);
        }       
    }
    public function slider($slug)
    {
        $rubro=Rubro::where('slug',$slug)->with('sliders')->first();
        $sliders=Slider_Rubro::where('rubro_id',$rubro->idrubro)->orderBy('type','Asc')->paginate(6);
        return view('panel.rubro.slider',compact('rubro','sliders'));
    }
     public function storeSlider(Request $request)
    {

       $validation = \Validator::make($request->all(),[
            'estado' => 'required|string',
            'titulo' => 'required|string',
            'orden' => 'required|string',
            'type' => 'required|string',
            'url' => 'required|string',
            'img_desktop' => 'required|mimes:jpg,png,jpeg|max:200',
            'img_phone' => 'required|mimes:jpg,png,jpeg|max:100',
            
        ],[
            'titulo.required' => 'Ingrese titulo',
        ]);

       if ($validation->fails()) {
            return response()->json(['errors'=>$validation->errors(),'status'=> 422]);
        }

        //Recuperando la extension de la imagen
            $extension =$request->file('img_desktop')->getClientOriginalExtension();
            $img_desktop= uniqid().'.'.$extension;

            $extension1 =$request->file('img_phone')->getClientOriginalExtension();
            $img_phone= uniqid().'.'.$extension1;
           


       $rubro=Rubro::where('idrubro',$request->idrubro)->first();

        $slider = new Slider_Rubro();

        if ($request->file('img_desktop')->move(public_path().'/imgRubro/',$img_desktop)) {  
        $slider->img_desktop=$img_desktop;
        }
        if ($request->file('img_phone')->move(public_path().'/imgRubro/',$img_phone)) {  
        $slider->img_phone=$img_phone;
        }

        $slider->estado = $request->estado;
        $slider->acceso = $request->acceso;
        $slider->titulo = $request->titulo;
        $slider->descripcion = $request->descripcion;
        $slider->orden = $request->orden;
        $slider->type = $request->type;
        $slider->url = $request->url;
        $slider->rubro_id = $request->idrubro;
        $slider->save();

        return redirect()->route('rubro.slider',$rubro->slug);

    }

    public function geteditSlider($id)
    {
        
        $slider=Slider_Rubro::where('id',$id)->first();
        $rubro=Rubro::where('slug',$slider->rubro->slug)->with('sliders')->first();
        $sliders=Slider_Rubro::where('rubro_id',$rubro->idrubro)->orderBy('type','Asc')->paginate(6);


        return view('panel.rubro.slider_edit',compact('slider','rubro','sliders'));
    }

    public function editSlider(Request $request)
    {

       $validation = \Validator::make($request->all(),[
            'estado' => 'required|string',
            'titulo' => 'required|string',
            'orden' => 'required|string',
            'type' => 'required|string',
            'url' => 'required|string',
            
        ],[
            'titulo.required' => 'Ingrese titulo',
        ]);

       if ($validation->fails()) {
            return response()->json(['errors'=>$validation->errors(),'status'=> 422]);
        }

       
           


       
    
        $slider = Slider_Rubro::find($request->idslider);

        if ($request->file('img_desktop')) {
                $validation = \Validator::make($request->all(),[
                    'img_desktop'   =>  'mimes:jpg,png,jpeg|max:200'
                ]);

                if($validation->fails()){
                    return response()->json(['errors' => $validation->errors()], 422);
                }
                //Borramos el archivo anterior
                if($slider->img_desktop && file_exists(public_path().'/imgRubro/'.$slider->img_desktop)){
                   unlink(public_path().'/imgRubro/'.$slider->img_desktop);
                }

                $extension =$request->file('img_desktop')->getClientOriginalExtension();
                $img_desktop= uniqid().'.'.$extension;
                if ($request->file('img_desktop')->move(public_path().'/imgRubro/',$img_desktop)) {  
                        $slider->img_desktop=$img_desktop;
                }
        }

         if ($request->file('img_phone')) {
                $validation = \Validator::make($request->all(),[
                    'img_phone'   =>  'mimes:jpg,png,jpeg|max:100'
                ]);

                if($validation->fails()){
                    return response()->json(['errors' => $validation->errors()], 422);
                }
                //Borramos el archivo anterior
                if($slider->img_phone && file_exists(public_path().'/imgRubro/'.$slider->img_phone)){
                   unlink(public_path().'/imgRubro/'.$slider->img_phone);
                }

                $extension1 =$request->file('img_phone')->getClientOriginalExtension();
                $img_phone= uniqid().'.'.$extension1;
                if ($request->file('img_phone')->move(public_path().'/imgRubro/',$img_phone)) {  
                        $slider->img_phone=$img_phone;
                }
        }

      


        $slider->estado = $request->estado;
        $slider->acceso = $request->acceso;
        $slider->titulo = $request->titulo;
        $slider->descripcion = $request->descripcion;
        $slider->orden = $request->orden;
        $slider->type = $request->type;
        $slider->url = $request->url;
        $slider->save();

        return redirect()->route('rubro.slider',$slider->rubro->slug);

    }
      public function destroySlider($id)
    {
        $slider = Slider_Rubro::find($id);

        $rubro=Rubro::where('idrubro',$slider->rubro_id)->first();

        $slider->delete();

        Session::flash('msg','¡Se eliminó un registro!');
        return redirect()->route('rubro.slider',$rubro->slug);
    }

}
