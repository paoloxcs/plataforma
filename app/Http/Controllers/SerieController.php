<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Rubro;
use App\Autor;
use App\Serie;
use App\Post;
use Session;
use Redirect;
use App\Categoria;
use App\Subcategoria;
class SerieController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('panel.serie.index');
    }

    public function getSeries(Request $request)
    {
      $series = Serie::orderBy('idserie','DESC')->with('post.subcategoria.categoria')->paginate(4);
      return response()->json($series);
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
      $validation = \Validator::make($request->all(),[
        'titulo'=>'required|string|max:250',
        'infoaddc'=>'required',
        'url_video'    =>'required|string|max:20',
        'portada'=>'required|mimes:jpg,png,jpeg| max:100',
        'duracion'=>'required',
        'idsubcategoria'=>'required',
        'idautor'=>'required',
        'url_preview'=>'required|string|max:20'
        ]);

      if($validation->fails()){
        return response()->json(['errors' => $validation->errors()], 422);
      }

        $imgnombre= uniqid().'.'.$request->file('portada')->getClientOriginalExtension();
        $request->file('portada')->move(public_path().'/posts/',$imgnombre);

        $slug = create_slug($request->titulo);

        //Guardan do la informacion en la tabla post
        $post = new Post();
        $post->type ='serie';
        $post->titulo =$request->titulo;
        $post->slug = $slug;
        $post->infoadd =$request->infoaddc;
        $post->idautor=$request->idautor;
        $post->ruta=$request->url_video;
        $post->fecha= date('Y-m-d');
        $post->idsubcategoria=$request->idsubcategoria;
        $post->image=$imgnombre;
        $post->orden = $request->orden;
        $post->acceso = $request->acceso;
        $post->save();

        //Guardando la informacion en la tabla series
        $serie = new Serie();
        $serie->idpost=$post->idpost;
        $serie->duracion=$request->duracion;
        $serie->url_preview = $request->url_preview;
        $serie->save();

        create_user_log('Agregó una nueva serie con el IDPOST: '.$post->idpost);

        return response()->json(['message'=>'El registro fue guardado con éxito'], 200);
        }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
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
        $validation =  \Validator::make($request->all(),[
            'titulo'=>'required|string|max:250',
            'infoadd'=>'required',
            'url_video'    =>'required|string|max:20',
            'duracion'=>'required',
            'idsubcategoria'=>'required',
            'idautor'=>'required',
            'url_preview'=>'required|string|max:20'
            ]);
        if($validation->fails()){
          return response()->json(['errors' => $validation->errors()], 422);
        }

        $post = Post::find($id);
        $serie = Serie::where('idpost',$request->post_id)->first();
        if ($request->file('portada')) {
            $this->validate($request,[
                'portada'=>'mimes:jpg,png,jpeg|max:100'
                ]);

            //Borrando la portada anterior
            if (file_exists(public_path().'/posts/'.$post->image)) {
                unlink(public_path().'/posts/'.$post->image);
            }
            
            $nomimg = uniqid().'.'.$request->file('portada')->getClientOriginalExtension();
            $request->file('portada')->move(public_path().'/posts/',$nomimg);
            $post->image=$nomimg;
        }

        $slug = create_slug($request->titulo);
        //guardando cambios
        $post->titulo= $request->titulo;
        $post->slug = $slug;
        $post->infoadd=$request->infoadd;
        $post->ruta=$request->url_video;
        $post->idautor=$request->idautor;
        $post->idsubcategoria=$request->idsubcategoria;
        $post->orden = $request->orden;
        $post->acceso = $request->acceso;
        $post->save();

        $serie->duracion =$request->duracion;
        $serie->url_preview =$request->url_preview;
        $serie->save();

        create_user_log('Actualizó el serie con el IDPOST: '.$post->idpost);
        //Retornado el mensaje de exito
        return response()->json(['message' => 'El registro fue modificado con éxito']);
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
        $post = Post::find($id);
        if (file_exists(public_path().'/posts/'.$post->image)) {
            unlink(public_path().'/posts/'.$post->image);
        }
        create_user_log('Eliminó el serie: '.strtoupper($post->titulo));
        $post->delete();
        //Retornado el mensaje de exito
        return response()->json(['message'=>'El registro fue eliminado con éxito'], 200);
        } catch (Exception $e) {
            dd($e);
        }
    }
    public function search($texto)
    {
        $series = Serie::join('posts as p','series.idpost','=','p.idpost')
        ->where('p.titulo','like','%'.$texto.'%')->with('post.subcategoria.categoria')->orderBy('series.idserie','desc')->limit(3)->get();
        return response()->json($series);
    }
}
