<div class="modal fade bd-example-modal-lg bd-example-modal{{$loop->iteration}}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title h4" id="myExtraLargeModalLabel"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">{{$enc->titulo}} - {{$enc->name}} {{$enc->last_name}}</font></font></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Cerca">
          <span aria-hidden="true"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">×</font></font></span>
        </button>
      </div>
  
      
      
        <div class="modal-body">
              
    
          
               <h2 class="text-center" style="font-weight: 700;margin-bottom: 4%;">{{$enc->titulo}} - {{$enc->name}} {{$enc->last_name}}</h2>
               
              <table class="table encuesta_table">
                <thead>
                  <tr>
                    <th scope="col"  rowspan="2">PREGUNTA</th>
                    <th scope="col" colspan="5" class="escala" style="padding:0.2%">ESCALA DE IMPORTANCIA</th>
                  </tr>
                  <tr>
                    <th scope="col">No me gustó</th>
                    <th scope="col">Me gustó</th>
                    <th scope="col">Me gustó mucho</th>
                  </tr>
                </thead>
                <tbody>
                   @foreach($encuestas as $encu)
                    @if($encu->id == $enc->encuesta_id)
                      @foreach($preguntas as $pre)
                          @if($pre->encuesta_id == $encu->id)
                              @foreach($respuestas as $re)
                                    @if($re->valor!='' and $re->user_id==$enc->user_id and $re->pregunta_id==$pre->id)
                                      <tr>
                                        <th>{{$pre->pregunta}}</th>
                                        @if($re->valor==1)
                                          <td><input class="medium" type="radio" disabled="" checked value="1"></td>
                                          <td><input class="medium" type="radio" disabled="" value="2"></td>
                                          <td><input class="medium" type="radio" disabled="" value="3"></td>
                                        @elseif($re->valor==2)
                                          <td><input class="medium" type="radio" disabled="" value="1"></td>
                                          <td><input class="medium" type="radio" disabled="" checked value="2"></td>
                                          <td><input class="medium" type="radio" disabled="" value="3"></td>
                                        @else
                                          <td><input class="medium" type="radio" disabled="" value="1"></td>
                                          <td><input class="medium" type="radio" disabled=""  value="2"></td>
                                          <td><input class="medium" type="radio" disabled="" checked value="3"></td>
                                        @endif
                                      </tr>
                                    @else
                                    @endif
                              @endforeach
                          @else
                          @endif
                      @endforeach
                    @else
                    @endif
                   @endforeach
                    @foreach($encuestas as $encu)
                    @if($encu->id == $enc->encuesta_id)
                      @foreach($preguntas as $pre)
                          @if($pre->encuesta_id == $encu->id)
                              @foreach($respuestas as $re)
                                    @if($re->texto!='' and $re->user_id==$enc->user_id and $re->pregunta_id==$pre->id)
                                      <tr>
                                        <th>{{$pre->pregunta}}</th>
                                        <td colspan="4" class="textarea_encuesta"><textarea  disabled="">{{$re->texto}}</textarea></td>
                                      </tr>
                     
                                    @else
                                    @endif
                              @endforeach
                          @else
                          @endif
                      @endforeach
                    @else
                    @endif
                   @endforeach
                     

                  
                       
                  

                 

                  <tr>
                    <th style="border:0.5px solid white"></th>
                  </tr>
                </tbody>
              </table>
              
      
              
       
          
      </div>

  </div>
</div>
</div>