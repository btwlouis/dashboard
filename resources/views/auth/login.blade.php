@extends('layouts.guest')

@section('content')
<body class="login-page" style="min-height: 466px;">
    <div class="login-box">
      <!-- /.login-logo -->
      <div class="card card-outline card-primary">
        <div class="card-header text-center">
          <a href="{{ route('dashboard') }}" class="h1"><b>b-service</b>.xyz</a>
        </div>
        <div class="card-body">

          @if ($errors->any())
            <div class="alert alert-danger">
                @foreach ($errors->all() as $error)
                  {{ $error }} <br>
                @endforeach
            </div>
          @endif

          <p class="login-box-msg">Melde dich an um loszulegen</p>

          <form action="{{ route('login') }}" method="post">
            @csrf
            <div class="input-group mb-3">
              <input type="email" class="form-control" placeholder="Email" name="email">
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-envelope"></span>
                </div>
              </div>
            </div>
            <div class="input-group mb-3">
              <input type="password" class="form-control" placeholder="Passwort" name="password">
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-lock"></span>
                </div>
              </div>
            </div>
            <div class="row">
              <!-- /.col -->
              <div class="col-12">
                <button type="submit" class="btn btn-primary btn-block">Einloggen</button>
              </div>
              <!-- /.col -->
            </div>
          </form>
    
          <p class="mb-0">
            <a href="{{ route('register') }}" class="text-center">Neuen Account erstellen</a>
          </p>
        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->
    </div>
    <!-- /.login-box -->
    

    @include('layouts.components.scripts')
    
</body>
@endsection