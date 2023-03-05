@extends('layouts.master')

@section('title', 'Template erstellen')

@section('content')

    @if ($errors->any())
        <div class="alert alert-danger">
            @foreach ($errors->all() as $error)
                {{ $error }}<br>
            @endforeach
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <h3>Template erstellen</h3>
                    <p>Erstelle ein neues Template</p>
                </div>
            </div>

            <form method="POST" action="{{ route('templates.store') }}">
                @csrf

                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Name">
                </div>

                <div class="form-group">
                    <label for="description">Beschreibung</label>
                    <textarea class="form-control" id="content" name="content" rows="3"></textarea>
                </div>

                <button type="submit" class="btn btn-primary">Template erstellen</button>
            </form>
        </div>
    </div>

@endsection