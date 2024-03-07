@extends('layouts.front')
@section('titulo')
{{$publicacion->nombrepublicacion}} Ed. {{$publicacion->nro}}
@endsection
@section('style-extra')
<div class="none">
@if(redirect()->getUrlGenerator()->previous()==Request::root().'/revistas/TM')
    {{$a='mineria'}}
@elseif(redirect()->getUrlGenerator()->previous()==Request::root().'/revistas/DA')
    {{$a='arquitectura-y-diseno'}}
@else
    {{$a='construccion'}}
@endif
{{--http://plataforma.constructivo.com--}}
</div>
<style type="text/css" media="screen">
    html, body  { height:100%; }
    body { margin:0; padding:0; overflow:auto; }
    #flashContent { display:none; }
    .flowpaper_toolbarstd{
        padding: 0 !important;
    }
</style>
{{-- <link rel="stylesheet" type="text/css" href="{{asset('revistas/'.$ruta.'/css/flowpaper.css')}}" />
<link rel="stylesheet" type="text/css" href="{{asset('revistas/'.$ruta.'/css/popover.css')}}" />
<link rel="stylesheet" type="text/css" href="{{asset('revistas/'.$ruta.'/css/popover-theme.css')}}" /> --}}

<link rel="stylesheet" type="text/css" href="{{asset('revistas/assets/css/flowpaper.css')}}" />
<link rel="stylesheet" type="text/css" href="{{asset('revistas/assets/css/popover.css')}}" />
<link rel="stylesheet" type="text/css" href="{{asset('revistas/assets/css/popover-theme.css')}}" />

@endsection
@section('content')
<div id="documentViewer" class="flowpaper_viewer" style="position:relative;;width:100%;height:100%;background-color:#222222;"></div>
<script type="text/javascript">
    window.onload = function(){
     $('#documentViewer').FlowPaperViewer(
             { config : {
                 PDFFile         : '/revistas/{{$ruta}}/docs/{{$ruta}}_[*,2,true].pdf',
                 IMGFiles        : '/revistas/{{$ruta}}/docs/{{$ruta}}.pdf_{page}.jpg',
                 HighResIMGFiles : '',
                 JSONFile        : '/revistas/{{$ruta}}/docs/{{$ruta}}.pdf_{page}.js',
                 ThumbIMGFiles   : '/revistas/{{$ruta}}/docs/{{$ruta}}.pdf_{page}_thumb.jpg',
                 SWFFile         : '',

                 Scale                   : 0.1,
                 ZoomTransition          : 'easeOut',
                 ZoomTime                : 0.4,
                 ZoomInterval            : 0.1,
                 FitPageOnLoad           : true,
                 FitWidthOnLoad          : false,
                 AutoAdjustPrintSize     : true,
                 PrintPaperAsBitmap      : false,
                 AutoDetectLinks         : true,
                 ImprovedAccessibility   : false,
                 FullScreenAsMaxWindow   : false,
                 ProgressiveLoading      : false,
                 MinZoomSize             : 0.1,
                 MaxZoomSize             : 5,
                 SearchMatchAll          : true,
                 InitViewMode            : 'Zine',
                 RenderingOrder          : 'html5,html',
                 StartAtPage             : 1,
                 EnableWebGL             : true,
                 PreviewMode             : '',
                 PublicationTitle        : 'Revista%20Constructivo%20%20Ed.%20129',
                 MixedMode               : true,
                 ViewModeToolsVisible    : true,
                 ZoomToolsVisible        : true,
                 NavToolsVisible         : true,
                 CursorToolsVisible      : true,
                 SearchToolsVisible      : true,

                 UIConfig                : '/revistas/{{$ruta}}/UI_Zine.xml?reload=1529444789371',
                 WMode                   : 'transparent',

                 key                     : '$62d11d8e620fba83654',
                 TrackingNumber          : 'UA-28100110-1',
                 localeDirectory         : '/revistas/{{$ruta}}/locale/',
                 localeChain             : 'es_ES'
             }}
     );

     var url = window.location.href.toString();
     if(location.length==0){
         url = document.URL.toString();
     }
     if(url.indexOf("file:")>=0){
         jQuery('#documentViewer').html("<div style='position:relative;background-color:#ffffff;width:420px;font-family:Verdana;font-size:10pt;left:22%;top:20%;padding: 10px 10px 10px 10px;border-style:solid;border-width:5px;'><img src='data:image/gif;base64,R0lGODlhEAAPAMQPAPS+GvXAIfrjnP/89vnZePrhlvS9F//+/PrfjfS/HfrgkPS+GP/9+YJiACAYAP////O3AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAACH5BAEAAA8ALAAAAAAQAA8AAAVQ4COOD0GQKElA0JmSg7EsxvCOCMsi9xPrkNpNwXI0WIoXA1A8QgCMVEFn1BVQS6rzGR1NtcCriJEAVnWJrgDI1gkehwD7rAsc1u28QJ5vB0IAOw%3D%3D'>&nbsp;<b>You are trying to use FlowPaper from a local directory.</b><br/><br/> Use the 'View in browser' button in the Desktop Publisher publish & preview dialog window to preview your publication or copy the contents of your publication directory to a web server and access this html file through a http:// url.</div>");
     }
    }
    
</script>

@endsection
@section('script-extra')
{{-- <script type="text/javascript" src="{{asset('revistas/'.$ruta.'/js/jquery.min.js')}}"></script>
<script type="text/javascript" src="{{asset('revistas/'.$ruta.'/js/jquery.extensions.min.js')}}"></script>
<script type="text/javascript" src="{{asset('revistas/'.$ruta.'/js/popover.min.js')}}"></script> --}}
<!--[if gte IE 10 | !IE ]><!-->
{{-- <script type="text/javascript" src="{{asset('revistas/'.$ruta.'/js/three.min.js')}}"></script> --}}
<!--<![endif]-->
{{-- <script type="text/javascript" src="{{asset('revistas/'.$ruta.'/js/flowpaper.js')}}"></script>
<script type="text/javascript" src="{{asset('revistas/'.$ruta.'/js/flowpaper_handlers.js')}}"></script> --}}

<script type="text/javascript" src="{{asset('revistas/assets/js/jquery.min.js')}}"></script>
<script type="text/javascript" src="{{asset('revistas/assets/js/jquery.extensions.min.js')}}"></script>
<script type="text/javascript" src="{{asset('revistas/assets/js/popover.min.js')}}"></script>
<!--[if gte IE 10 | !IE ]><!-->
<script type="text/javascript" src="{{asset('revistas/assets/js/three.min.js')}}"></script>
<!--<![endif]-->
<script type="text/javascript" src="{{asset('revistas/assets/js/flowpaper.js')}}"></script>
<script type="text/javascript" src="{{asset('revistas/assets/js/flowpaper_handlers.js')}}"></script>
@endsection