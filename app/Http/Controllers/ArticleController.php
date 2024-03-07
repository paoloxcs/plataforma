<?php

namespace App\Http\Controllers;

use App\Paper;
use App\Post;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function index()
    {
    	return view('panel.paper.index');
    }

    public function getArticles(Request $request)
    {
    	$articles = Paper::orderBy('idpaper','desc')->with('post.subcategoria.categoria')->paginate(5);
    	return response()->json($articles);
    }
    public function store(Request $request)
    {
    	$validation =  \Validator::make($request->all(),[
    		'titulo' 	=>	'required|string',
    		'infoadd' 	=>	'required',
    		'pdf'		=>	'required|mimes:pdf',
    		'portada'	=>	'required|mimes:jpg,png,jpeg|max:100',
    		'pages'		=>	'required|numeric',
    	]);
    	if($validation->fails()){
    		return response()->json(['errors' => $validation->errors()], 422);
    	}

    	// Subida de archivos
		$nompdf =uniqid().'.'.$request->file('pdf')->getClientOriginalExtension();
		$nomportada = uniqid().'.'.$request->file('portada')->getClientOriginalExtension();
		$request->file('pdf')->move(public_path().'/posts/',$nompdf);
		$request->file('portada')->move(public_path().'/posts/',$nomportada);

		//Guardan do la informacion en la tabla post
		$post = new Post();
		$post->type ='articulo';
		$post->titulo =$request->titulo;
		$post->slug = create_slug($request->titulo);
		$post->infoadd =$request->infoadd;
		$post->idautor=$request->idautor;
		$post->ruta = $nompdf;
		$post->fecha = date("Y-m-d");
		$post->idsubcategoria=$request->idsubcategoria;
		$post->image=$nomportada;
		$post->idioma =$request->idioma;
		$post->orden = $request->orden;
		$post->acceso = $request->acceso;
		$post->save();

		//Guardando la informacion en la tabla papers
		$paper = new Paper();
		$paper->idpost= $post->idpost;
		$paper->pages=$request->pages;
		$paper->fechaimp=$request->fechaimp;
		$paper->save();

        create_user_log('Agregó un artículo con el IDPOST: '.$post->idpost);
		//Retornado el mensaje de exito
		return response()->json(['message' => 'Registro exitoso!']);
    }

    public function update(Request $request, $id)
    {
    	$validation =  \Validator::make($request->all(),[
    		'titulo' 	=>	'required|string',
    		'infoadd' 	=>	'required',
    		'pages'		=>	'required|numeric',
    	]);

    	if($validation->fails()){
    		return response()->json(['errors' => $validation->errors()], 422);
    	}

    	 $post = Post::find($id);
    	 $paper = Paper::where('idpost',$post->idpost)->first();

    	 if ($request->file('pdf')) {
    	     //Borramos el archivo anterior si existe
    	     if(file_exists(public_path().'/posts/'.$post->ruta)){
    	         unlink(public_path().'/posts/'.$post->ruta);
    	     }

    	     $nompdf = uniqid().'.'.$request->file('pdf')->getClientOriginalExtension();
    	     $request->file('pdf')->move(public_path().'/posts/',$nompdf);
    	     $post->ruta=$nompdf;
    	 }
    	 
    	  if($request->file('portada')){
    	     if(file_exists(public_path().'/posts/'.$post->image)){
    	         //Borramos la portada anterior
    	         unlink(public_path().'/posts/'.$post->image);
    	     }
    	     
    	     //Recueperando el nomnre de la imagen y concantenando con el time
    	     $nomportada =uniqid().'.'.$request->file('portada')->getClientOriginalExtension();
    	     //Subiendo el archivo al servidor
    	     $request->file('portada')->move(public_path().'/posts/',$nomportada);
    	     $post->image=$nomportada;
    	 }

    	 //almacenado registros en la base de datos
    	 if($request->titulo != $post->titulo){
    	 	$post->titulo= $request->titulo;
    	 	$post->slug = create_slug($request->titulo);
    	 }
    	 $post->infoadd=$request->infoadd;
    	 $post->idautor=$request->idautor;
    	 $post->idsubcategoria=$request->idsubcategoria;
    	 $post->idioma=$request->idioma;
    	 $post->orden = $request->orden;
    	 $post->acceso = $request->acceso;
    	 $post->save();

    	 //Guardando la informacion en la tabla papers
    	 $paper->pages=$request->pages;
    	 $paper->save();

         create_user_log('Actualizó un artículo con el IDPOST: '.$post->idpost);
    	 //Retornado el mensaje de exito
    	 return response()->json(['message' => 'Actualización exitosa!']);
    }

    public function search($texto)
    {
    	$articles = Paper::join('posts as p','papers.idpost','=','p.idpost')
    	->where('p.titulo','like','%'.$texto.'%')->with('post.subcategoria.categoria')->orderBy('papers.idpaper','desc')->limit(3)->get();
    	return response()->json($articles);
    }

    public function destroy($id)
    {
    	$post = Post::find($id);
    	if (file_exists(public_path().'/posts/'.$post->image)) {
    	    unlink(public_path().'/posts/'.$post->image);
    	}
    	if (file_exists(public_path().'/posts/'.$post->ruta)) {
    	    unlink(public_path().'/posts/'.$post->ruta);
    	}

        create_user_log('Eliminó el artículo: '.strtoupper($post->titulo));

    	$post->delete(); // Borrando el post

    	return response()->json(['message'=>'Registro eliminado']);
    }
}
