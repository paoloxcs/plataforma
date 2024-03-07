<?php

namespace App\Http\Controllers;
use Session;
use App\Sponsor;
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



class SponsorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sponsors = Sponsor::orderBy('id','desc')->paginate(8);

        if(!\Auth::guest()) {
            if(Auth()->user()->isAdmin() or Auth()->user()->isContentManager()){
              return view('panel.sponsor.index',compact('sponsors'));
            }
            else{
                return back()->with('');
            }
        }
       
     
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
            'url_logo' => 'required|mimes:jpg,png,jpeg|max:100',
            'url_web' => 'required|string'
           
            ]);
            if($validation->fails()){
            return response()->json(['errors' => $validation->errors()], 422);
            }
            //Recuperando la extension de la imagen
            $extension =$request->file('url_logo')->getClientOriginalExtension();
            $imgnombre= uniqid().'.'.$extension;

             

            if ($request->file('url_logo')->move(public_path().'/imgCurso/',$imgnombre)) {


                   
                $sponsor = new Sponsor();
                $sponsor->nombre = $request->nombre;
                $sponsor->url_logo = $imgnombre;
                $sponsor->url_web = $request->url_web;

                $sponsor->save();

             }   
            


      Session::flash('msg','¡Registro exitoso!');
       return redirect()->route('sponsors');
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
        $sponsor = Sponsor::find($id);
        return view('panel.sponsor.edit',compact('sponsor'));
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
             'nombre' => 'required|string',
            'url_web' => 'required|string'
           
            
           
            ]);

        if ($validation->fails()) {
            return response()->json(['errors' => $validation->errors()], 422);
        }

        $sponsor = Sponsor::find($id);
       

         if ($request->file('url_logo')) {
            $validation = \Validator::make($request->all(),[
            'url_logo' => 'required|mimes:jpg,png,jpeg|max:100',
           
            ]);

            if($validation->fails()){
                return response()->json(['errors' => $validation->errors()], 422);
            }
            //Borramos el archivo anterior
            if($sponsor->url_logo && file_exists(public_path().'/imgCurso/'.$sponsor->url_logo)){
               unlink(public_path().'/imgCurso/'.$sponsor->url_logo);
            }
            //Recuperando la extension de la imagen
            $extension =$request->file('url_logo')->getClientOriginalExtension();
            $imgnombre= uniqid().'.'.$extension;
            if ($request->file('url_logo')->move(public_path().'/imgCurso/',$imgnombre)) {
                $sponsor->url_logo = $imgnombre;
            }
        }


       
        $sponsor->nombre = $request->nombre;
        $sponsor->url_web = $request->url_web;       
      
        $sponsor->save();

        return redirect()->route('sponsors');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $sponsor = Sponsor::find($id);

        $sponsor->delete();

        Session::flash('msg','¡Se eliminó un registro!');
        return redirect()->route('sponsors');
    }

    public function buscador(Request $request){
        $sponsors=Sponsor::where("nombre",'like',"%".$request->texto."%")->orWhere("id",'like',"%".$request->texto."%")->orWhere("url_web",'like',"%".$request->texto."%")->orderBy('nombre','Asc')->limit(8)->get();

        return view('panel.sponsor.buscador',compact('sponsors'));
    }
   
}

