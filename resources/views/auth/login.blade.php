@extends('layout.base')

@section('style')
    @vite('resources/css/login.css')
@endsection

@section('content')
  <div class="container">
      {{-- mensajes de error --}}
      {{-- @include('partials.mensajes') --}}
      <div class='card' id="login">
        <a id="close-btn" href="{{url('/')}}">
          <i class="bi bi-x-lg"></i>
        </a>
        <div class="card-body text-center">
          <h3 class="card-title">LOGIN</h3>  
          <p class="card-text my-4">Introdueix el teu usuari i contrasenya </p>
          <div class="form-container">
            <form action="{{action([App\Http\Controllers\UsuarioController::class, 'login'])}}" method="POST">
                @csrf
                <div class="mb-3">
                  {{-- <label for="userName" class="form-label">Nom d'usuari</label> --}}
                  <input type="text" class="form-control" id="userName" name="userName" placeholder="Usuari" autofocus value="{{old('userName')}}">
                </div>
                <div class="mb-3">
                  {{-- <label for="password1" class="form-label">Contrasenya</label> --}}
                  <input type="password" class="form-control" id="password1" name="password1" placeholder="Contrasenya">
                </div>
                <div class="mt-5 ">
                  <a href="{{url('/registre')}}" class="card-link">No tens cap compte? Crea't un</a>
                </div>
                <button type="submit" class="btn btn-outline-primary mt-4">Aceptar</button> 
              </form>
            </div>

              
        </div>

      </div>
  </div>
@endsection