<?php

namespace App\Http\Controllers;
use Session;
use App\Sponsor;
use App\SponsorCurso;
use App\Curso;
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



class SponsorCursoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sponsorcursos = SponsorCurso::orderBy('id','desc')->paginate(8);
        $sponsors=Sponsor::orderBy('nombre','asc')->get();
        $cursos=Curso::where('estado','=','1')->where('expira','>',date('Y-m-d'))->orderBy('titulo','asc')->get();
        return view('panel.sponsorcurso.index',compact('sponsorcursos','sponsors','cursos'));
        
    }

     public function sponsorcurso()
    {
        $sponsorcursos = SponsorCurso::orderBy('id','desc')->paginate(8);
        $sponsors=Sponsor::orderBy('nombre','asc')->get();
        $cursos=Curso::where('estado','=','1')->where('expira','>',date('Y-m-d'))->orderBy('titulo','asc')->get();
        return view('panel.sponsorcurso.index',compact('sponsorcursos','sponsors','cursos'));
        
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
            'curso_id' => 'required|string',
            'sponsor_id' => 'required|string'

            ]);
            if($validation->fails()){
            return response()->json(['errors' => $validation->errors()], 422);
            }


            $sponsorcursos=SponsorCurso::get();
            $count=0;
           foreach ($sponsorcursos as $sponsorcurso) {
            if ($sponsorcurso->curso_id== $request->curso_id and $sponsorcurso->sponsor_id==$request->sponsor_id) {

                $count= $count + 1;
            }
               
           }
            
            if ($count==0) {
                $sponsorcontact = new SponsorCurso();
                $sponsorcontact->curso_id = $request->curso_id;
                $sponsorcontact->sponsor_id = $request->sponsor_id;
                $sponsorcontact->user_id = Auth()->user()->id;
                $sponsorcontact->save();

                Session::flash('msg','¡Registro exitoso!');
                return redirect('panel/sponsors/curso/');                       
            }else{
                Session::flash('msg','El registro ya existe');
               return redirect('panel/sponsors/curso/');
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
        $sponsorcontact = SponsorCurso::find($id);
       
        return view('panel.sponsorcontact.edit',compact('sponsorcontact'));
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
            'email' => 'required|email'  
            ]);

        if ($validation->fails()) {
            return response()->json(['errors' => $validation->errors()], 422);
        }

        $sponsorcontact = SponsorCurso::find($id);
        

         if ($request->file('nombre')) {
          $validation = \Validator::make($request->all(),[
                'nombre' => 'required|string'
          ]);

         }

        $sponsorcontact->email = $request->email;
        $sponsorcontact->nombre = $request->nombre;
        $sponsorcontact->save();

        return redirect('panel/sponsors/contactos/'.$sponsorcontact->sponsor_id);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $sponsorcurso = SponsorCurso::find($id);

        $sponsorcurso->delete();

        Session::flash('msg','¡Se eliminó un registro!');
        return redirect(url()->previous());
    }

    public function buscador(Request $request){
        $sponsors=Sponsor::where("titulo",'like',"%".$request->texto."%")->orWhere("descripcion",'like',"%".$request->texto."%")->orWhere("informacion",'like',"%".$request->texto."%")->orWhere("precio",'like',"%".$request->texto."%")->orWhere("promocion",'like',"%".$request->texto."%")->orWhere("fecha",'like',"%".$request->texto."%")->orderBy('titulo','Asc')->limit(8)->get();

        return view('panel.sponsor.buscador',compact('sponsors'));
    }
   
}
