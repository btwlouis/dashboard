@extends('layouts.master')

@section('title', 'Benutzer (' . $user->name . ') bearbeiten')

@section('content')

    <!-- show user edit form -->

    <div class="row">
        <div class="col-6">
            <!-- display errors -->
            @if ($errors->any())
                <div class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                        {{ $error }} <br>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
    
    <div class="row">
        <div class="col-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Benutzer bearbeiten</h3>
                </div>
        
                <form method="POST" action="{{  route('user.update', $user->id) }}">
        
                    @csrf
                    @method('PUT')
        
                    <div class="card-body">
                                        


                        <div class="input-group mb-3">
                            <input type="email" class="form-control" placeholder="E-Mail" name="email" value="{{ $user->email }}">
                            <div class="input-group-append">
                              <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                              </div>
                            </div>
                        </div>
        
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" placeholder="Name" name="name" value="{{ $user->name }}">
                            <div class="input-group-append">
                              <div class="input-group-text">
                                <span class="fas fa-user"></span>
                              </div>
                            </div>
                        </div>
        
                        <div class="input-group mb-3">
                            <input type="password" class="form-control" placeholder="Neues Passwort setzen" name="password">
                            <div class="input-group-append">
                              <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                              </div>
                            </div>
                        </div>
        
                        <div class="input-group mb-3">
                            <input type="password" class="form-control" placeholder="Neues Passwort wiederholen" name="password_confirmation">
                            <div class="input-group-append">
                              <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                              </div>
                            </div>
                        </div>
        
                        @foreach($permissions as $permission)
                            <div class="row">
                                <div class="col-12">
                                    <div class="icheck-primary">
                                        <input type="checkbox" id="checkboxPrimary" name="permissions[]" value="{{ $permission->id }}" {{ $user->hasPermission($permission->name) ? 'checked' : '' }}>
                                        <label for="checkboxPrimary">
                                            {{ $permission->name }}
                                        </label>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        
                        <div class="row">
                            <!-- /.col -->
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary btn-block">Speichern</button>
                            </div>
                            <!-- /.col -->
                        </div>
        
                    </div>
        
                </form>
        
        
            </div>
        </div>
    </div>
    


@endsection 