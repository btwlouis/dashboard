@extends('layouts.master')

@section('title', 'Vorlage bearbeiten')

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
                    <h3>Vorlagen bearbeiten</h3>
                    <p>Bearbeite die Vorlage</p>
                </div>
            </div>

            <form method="POST" action="{{ route('templates.update', $template->id) }}">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Name" value="{{ $template->name }}">
                </div>

                <div class="form-group">
                    <label for="description">Beschreibung</label>
                    <textarea class="form-control" id="content" name="content" rows="3">{{ $template->content }}</textarea>
                </div>

                <button type="submit" class="btn btn-primary">Vorlage bearbeiten</button>
            </form>
        </div>
    </div>

@endsection