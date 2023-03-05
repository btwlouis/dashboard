@extends('layouts.master')

@section('title', 'Tickets')

@section('content')
    <!-- loop and show all tickets in a table -->

    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <h3>Tickets</h3>
                    <p>Aktuell sind <b>{{ count($tickets) }}</b> Tickets offen</p>

                    <table class="table" id="table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">Zugeordnet zu</th>
                                <th scope="col">Status</th>
                                <th scope="col">Aktualisiert am</th>
                                <th scope="col">Aktionen</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($tickets as $ticket)
                                <tr>
                                    <th scope="row">{{ $ticket->id }}</th>
                                    <td>{{ $ticket->name }}</td>
                                    <td>
                                        @if($ticket->user_id == Auth::user()->id)
                                            <span class="badge badge-success">Dir zugewiesen</span>
                                        @elseif($ticket->user_id == null)
                                            <span class="badge badge-danger">Nicht zugewiesen</span>
                                        @else
                                            <span class="badge badge-info">
                                                {{ $ticket->user->name }}
                                            </span> 
                                        @endif
                                    </td>
                                    <td>
                                        @switch($ticket->status)
                                            @case('open')
                                                <span class="badge badge-success">Offen</span>
                                                @break
                                            @case('in_progress')
                                                <span class="badge badge-warning">In Bearbeitung</span>
                                                @break
                                            @case('closed')
                                                <span class="badge badge-danger">Geschlossen</span>
                                                @break
                                            @default
                                                <span class="badge badge-secondary">Kein Status</span>
                                        @endswitch
                                    </td>
                                    
                                    <td>{{ Carbon\Carbon::parse($ticket->updated_at)->format('d.m.Y - H:i') }}</td>
                                    <td>
                                        <a href="{{ route('ticket.show', $ticket->id) }}" class="btn btn-primary">Anzeigen</a>
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
