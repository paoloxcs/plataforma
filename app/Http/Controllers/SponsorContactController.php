<?php

namespace App\Http\Controllers;
use Session;
use App\Sponsor;
use App\SponsorContact;
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



class SponsorContactController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $contactos = SponsorContact::orderBy('id','desc')->paginate(8);
        return view('panel.sponsorcontact.index',compact('contactos'));
        
    }

     public function contactos($id)
    {
        $contactos = SponsorContact::where('sponsor_id','=',$id)->orderBy('id','desc')->paginate(8);
        $sponsor = Sponsor::where('id','=',$id)->first();
        return view('panel.sponsorcontact.index',compact('contactos','sponsor'));
        
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
            'email' => 'required|email',
         
            ]);
            if($validation->fails()){
            return response()->json(['errors' => $validation->errors()], 422);
            }

             if ($request->file('nombre')) {
             $validation = \Validator::make($request->all(),[
                'nombre' => 'required|string'
            ]);

             }
                                   
                $sponsorcontact = new SponsorContact();
                $sponsorcontact->email = $request->email;
                $sponsorcontact->sponsor_id = $request->sponsor_id;
                $sponsorcontact->nombre = $request->nombre;
                $sponsorcontact->save();

      Session::flash('msg','¡Registro exitoso!');
       return redirect('panel/sponsors/contactos/'.$request->sponsor_id);
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
        $sponsorcontact = SponsorContact::find($id);
       
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

        $sponsorcontact = SponsorContact::find($id);
        

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
        $sponsorcontact = SponsorContact::find($id);

        $sponsorcontact->delete();

        Session::flash('msg','¡Se eliminó un registro!');
        return redirect(url()->previous());
    }

    public function buscador(Request $request){
        $sponsors=Sponsor::where("titulo",'like',"%".$request->texto."%")->orWhere("descripcion",'like',"%".$request->texto."%")->orWhere("informacion",'like',"%".$request->texto."%")->orWhere("precio",'like',"%".$request->texto."%")->orWhere("promocion",'like',"%".$request->texto."%")->orWhere("fecha",'like',"%".$request->texto."%")->orderBy('titulo','Asc')->limit(8)->get();

        return view('panel.sponsor.buscador',compact('sponsors'));
    }
   
}
