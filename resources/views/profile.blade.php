@extends('layouts.master')

@section('title', 'Profil')

@section('content')

    <div class="row">
        <div class="col-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Profil</h3>
                </div>

                <div class="card-body">
                    <!-- show form inputs with data from user -->
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}" disabled>
                        
                    </div>
        
                    <div class="form-group">
                        <label for="email">E-Mail</label>
                        <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}" disabled>
                    </div>

                    <div class="form-group">
                        <label for="created_at">Erstellt am</label>
                        <input type="text" class="form-control" id="created_at" name="created_at" value="{{ Carbon\Carbon::parse($user->created_at)->format('d.m.Y - H:i') }}" disabled>

                    </div>

                </div>
            </div>
        </div>

        <div class="col-6">
            
        </div>
    </div>


@endsection