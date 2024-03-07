@extends('layouts.front')
@section('titulo','Chatea con los demas usuarios')
<style>
  .fa-dice-one{
    color: green;
  }
  .typing{
    color: rgba(0,0,0,0.6);
    font-size: 13px;
    padding: 7px 0;
  }
  img{ max-width:100%;}
  .inbox_people {
    background: #f8f8f8 none repeat scroll 0 0;
    float: left;
    overflow: hidden;
    width: 40%; border-right:1px solid #c4c4c4;
  }
  .inbox_msg {
    border: 1px solid #c4c4c4;
    clear: both;
    overflow: hidden;
  }
  .top_spac{ margin: 20px 0 0;}


  .recent_heading {float: left; width:40%;}
  .srch_bar {
    display: inline-block;
    text-align: right;
    width: 60%; padding:
  }
  .headind_srch{ padding:10px 29px 10px 20px; overflow:hidden; border-bottom:1px solid #c4c4c4;}

  .recent_heading h4 {
    color: #05728f;
    font-size: 21px;
    margin: auto;
  }
  .srch_bar input{ border:1px solid #cdcdcd; border-width:0 0 1px 0; width:80%; padding:2px 0 4px 6px; background:none;}
  .srch_bar .input-group-addon button {
    background: rgba(0, 0, 0, 0) none repeat scroll 0 0;
    border: medium none;
    padding: 0;
    color: #707070;
    font-size: 18px;
  }
  .srch_bar .input-group-addon { margin: 0 0 0 -27px;}

  .chat_ib h5{ font-size:15px; color:#464646; margin:0 0 8px 0;}
  .chat_ib h5 span{ font-size:13px; float:right;}
  .chat_ib p{ font-size:14px; color:#989898; margin:auto}
  .chat_img {
    float: left;
    width: 11%;
  }
  .chat_ib {
    float: left;
    padding: 0 0 0 15px;
    width: 88%;
  }

  .chat_people{ overflow:hidden; clear:both;}
  .chat_list {
    border-bottom: 1px solid #c4c4c4;
    margin: 0;
    padding: 18px 16px 10px;
  }
  .inbox_chat { height: 340px; overflow-y: scroll;}

  .active_chat{ background:#ebebeb;}

  .incoming_msg_img {
    display: inline-block;
    width: 6%;
    margin: 26px 0 26px;
  }
  .received_msg {
    display: inline-block;
    padding: 0 0 0 10px;
    vertical-align: top;
    width: 92%;
   }
   .received_withd_msg p {
    background: #ebebeb none repeat scroll 0 0;
    border-radius: 3px;
    color: #646464;
    font-size: 14px;
    margin: 0;
    padding: 5px 10px 5px 12px;
    width: 100%;
  }
  .time_date {
    color: #747474;
    display: block;
    font-size: 12px;
    margin: 8px 0 0;
  }
  .received_withd_msg { width: 90%;}
  .mesgs {
    float: left;
    padding: 30px 15px 0 25px;
    width: 60%;
  }

   .sent_msg p {
    background: #05728f none repeat scroll 0 0;
    border-radius: 3px;
    font-size: 14px;
    margin: 0; color:#fff;
    padding: 5px 10px 5px 12px;
    width:100%;
  }
  .outgoing_msg{ overflow:hidden; margin:26px 0 26px;}
  .sent_msg {
    float: right;
    width: 90%;
  }
  .input_msg_write input {
    background: rgba(0, 0, 0, 0) none repeat scroll 0 0;
    border: medium none;
    color: #4c4c4c;
    font-size: 15px;
    min-height: 48px;
    width: 100%;
    padding: 0 15px;
  }

  .input_msg_write input:focus{
    outline: none;
  }

  .type_msg {border-top: 1px solid #c4c4c4;position: relative;}
  .msg_send_btn {
    background: #05728f none repeat scroll 0 0;
    border: medium none;
    border-radius: 50%;
    color: #fff;
    cursor: pointer;
    font-size: 17px;
    height: 33px;
    position: absolute;
    right: 0;
    top: 11px;
    width: 33px;
  }
  .messaging { padding: 0 0 50px 0;}
  .msg_history {
    height: 340px;
    overflow-y: auto;
  }
</style>
@section('content')
<div class="none">{{$a='construccion'}}</div>
<div class="container">
  <div class="row mt-5 mb-3">
    <div class="col-xs-12 col-md-3">
      @include('web.profile.menu')
    </div>
    <div class="col-xs-12 col-md-9">
      <div class="card">
        <div class="card-header">Chat grupal - Plataforma de Igeniería</div>
      </div>
        <div class="messaging">
              <div class="inbox_msg">
                <div class="inbox_people">
                  <div class="headind_srch">
                    <div class="recent_heading">
                      <h4>En linea</h4>
                    </div>
                    {{-- <div class="srch_bar">
                      <div class="stylish-input-group">
                        <input type="text" class="search-bar"  placeholder="Search" >
                        <span class="input-group-addon">
                        <button type="button"> <i class="fa fa-search" aria-hidden="true"></i> </button>
                        </span> </div>
                    </div> --}}
                  </div>
                  <div class="inbox_chat" id="users_online">
                    
                  </div>
                </div>
                <div class="mesgs">
                  <div class="msg_history" id="messages">
                    

                  </div>
                    <span class="typing" id="typing"></span>
                  <div class="type_msg">
                    <div class="input_msg_write">
                      <input type="text" onkeyup="handleInput(this)" class="write_msg" placeholder="Escribe un mensaje" />
                      {{-- <button class="msg_send_btn" type="button"><i class="fa fa-paper-plane" aria-hidden="true"></i></button> --}}
                      {{-- <span class="time_date"> 11:01 AM    |    June 9</span></div> --}}
                    </div>
                  </div>
                </div>
              </div>
            </div>
    </div>
  </div>
  
</div>
@endsection
@section('script-extra')
<script src="http://localhost:3000/socket.io/socket.io.js"></script>
{{-- <script src="https://constructivo.com:3000/socket.io/socket.io.js"></script> --}}
<script>
  const socket  = io('http://localhost:3000');
  /*const socket  = io('https://constructivo.com:3000');*/
  $(document).ready(function(){
    getMessages();
    
  });
  let props = {
    messages : $("#messages"),
    users_online : $("#users_online"),
  }

  let current_user  = {
    user_id: {{Auth()->user()->id}},
    user: '{{Auth()->user()->fullName()}}',
    role: '{{Auth()->user()->role->name}}',
  }

  socket.emit('newuser', current_user);

  function getMessages() {
    $.ajax({
      url: '/profile/messages',
      type: 'GET',
      dataType: 'JSON',
      success: resp =>{
        props.messages.empty();
        resp.forEach(chat =>{
          if(current_user.user_id == chat.user_id){
            props.messages.append(`
              <div class="outgoing_msg">
                <div class="sent_msg">
                  <p>${chat.message}</p>
              </div>
              `);
          }else{
            props.messages.append(`
              <div class="incoming_msg">
                <div class="incoming_msg_img"> <img src="https://ptetutorials.com/images/user-profile.png" alt="sunil"> </div>
                <div class="received_msg">
                  <div class="received_withd_msg">
                    <p><strong>${chat.user.name}</strong><small>(${chat.user.role.name})</small></p>
                    <p>${chat.message}</p>
                </div>
              </div>
              `);
          }
          
        });

        $(".msg_history").stop().animate({ scrollTop: $(".msg_history")[0].scrollHeight}, 1000);
      },
      error: err =>{
        console.log(err);
      }
    });
  }
  function handleInput(input) {
    $("#typing").empty();
    if (input.value) {
      socket.emit('chat:typing',current_user.user);
      senMessage(input);
    }
  }

  function senMessage(input) {
    let token = '{{csrf_token()}}';
      if(event.keyCode == 13){
        let data = {'message' : input.value};
        socket.emit('chat:message', {
          user_id: current_user.user_id,
          user: current_user.user,
          role: current_user.role,
          message: data.message
        });

        $.ajax({
          url: '/profile/message',
          type: 'POST',
          headers: {'X-CSRF-TOKEN': token},
          dataType: 'JSON',
          data: data,
          success: resp =>{           

            input.value = '';
            console.log(resp);
          },  
          error: err =>{
            console.log(err);
          }
        });
      }
  }
      socket.on('chat:typing', function(user){
        $("#typing").text(`${user} está escribiendo`);
      });
      socket.on('chat:message', function(resp){
        $("#typing").empty();
        if(current_user.user_id == resp.user_id){
          props.messages.append(`
            <div class="outgoing_msg">
              <div class="sent_msg">
                <p>${resp.message}</p>
            </div>
            `);
        }else{
          props.messages.append(`
            <div class="incoming_msg">
              <div class="incoming_msg_img"> <img src="https://ptetutorials.com/images/user-profile.png" alt="sunil"> </div>
              <div class="received_msg">
                <div class="received_withd_msg">
                <p><strong>${resp.user}</strong><small>(${resp.role})</small></p>
                  <p>${resp.message}</p>
              </div>
            </div>
            `);
        }
        $(".msg_history").stop().animate({ scrollTop: $(".msg_history")[0].scrollHeight}, 1000);
        });

      socket.on('online-users', function(resp){
        props.users_online.empty();
        resp.forEach(data =>{
            if(data.user_id != current_user.user_id){
              props.users_online.append(`
                <div class="chat_list active_chat">
                  <div class="chat_people">
                    <div class="chat_img"> <img src="https://ptetutorials.com/images/user-profile.png" alt="sunil"> </div>
                    <div class="chat_ib">

                      <h5><i class="fas fa-dice-one"></i> ${data.user}</h5>
                      <span class="chat_date"><small>${data.role}</small></span>
                    </div>
                  </div>
                </div>
                `);
            }
          });
        });
</script>
@endsection