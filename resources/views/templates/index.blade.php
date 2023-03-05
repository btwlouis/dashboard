@extends('layouts.master')

@section('title', 'Templates')

@section('content')
    <!-- loop and show all templates in a table -->

    <!-- success message -->
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <h3>Neue Vorlage erstellen</h3>
                    <p>Erstelle eine neue Vorlage</p>
                    <a href="{{ route('templates.create') }}" class="btn btn-primary">Neue Vorlage erstellen</a>
                </div>
            </div>
        </div>
    </div>


    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <h3>Vorlagen</h3>
                    <p>Aktuell sind <b>{{ count($templates) }}</b> Vorlagen vorhanden</p>

                    <table class="table" id="table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">Beschreibung</th>
                                <th scope="col">Bearbeitet am</th>
                                <th scope="col">Aktionen</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($templates as $template)
                                <tr>
                                    <th scope="row">{{ $template->id }}</th>
                                    <td>{{ $template->name }}</td>
                                    <td>{{ $template->content }}</td>
                                    <td>{{ Carbon\Carbon::parse($template->updated_at)->format('d.m.Y - H:i') }}</td>
                                    <td>
                                        <a href="{{ route('templates.edit', $template->id) }}" class="btn btn-warning btn-sm">Bearbeiten</a>
                                        <form action="{{ route('templates.destroy', $template->id) }}" method="POST" style="display: inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">Löschen</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection