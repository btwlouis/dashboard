@extends('layouts.master')

@section('title', 'Protokoll')

@section('content')


    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Protokoll</h3>
        </div>

        <div class="card-body">
            <table class="table table-bordered table-striped" id="table">
                <thead>
                    <tr>
                        <th>Benutzer</th>
                        <th>Aktion</th>
                        <th>Zeitpunkt</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($logs as $log)
                        <tr>
                            <td>{{ $log->causer->name }}</td>
                            <td>{{ $log->description }}</td>
                            <td>{{ Carbon\Carbon::parse($log->created_at)->format('d.m.Y - H:i') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
    </div>
    
@endsection
