<div class="none">{{$a='construccion'}}</div>
<div class="menu-user mb-3">
  <h4 class="title text-center">
    Configuración
  </h4>
    <ul class="list-group">
      <li class="list-group-item">
        <a class="{{ Route::is('edituser') ? 'active' : '' }}" href="{{route('edituser')}}"><i class="fas fa-user"></i> Mi perfil</a>
      </li>
      
      <li class="list-group-item">
        <a class="{{ Route::is('changepassword') ? 'active' : '' }}" href="{{route('changepassword')}}"><i class="fas fa-unlock"></i> Contraseña</a>
      </li>
      <li class="list-group-item">
        <a class="{{ Route::is('suscription') ? 'active' : '' }}" href="{{route('suscription')}}"><i class="far fa-file-alt"></i> Suscripción</a>
      </li>
      <li class="list-group-item">
        <a class="{{ Route::is('favoritos') ? 'active' : '' }}" href="{{route('favoritos')}}"><i class="fas fa-star"></i> Favoritos</a>
      </li>
      {{-- <li class="list-group-item">
        <a class="{{ Route::is('chat.index') ? 'active' : '' }}" href="{{route('chat.index')}}"><i class="fas fa-user-friends"></i> Chat en linea <small class="pull-right" style="font-style: italic;">Beta</small></a>
      </li> --}}

    </ul>
</div>