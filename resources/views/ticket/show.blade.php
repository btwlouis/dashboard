@extends('layouts.master')

@section('title', 'Ticket #' . $ticket->id . ' - ' . $ticket->name)

@section('content')

    <div class="row">
        <div class="col-12">
            <!-- alert if ticket is assigned -->

            @if($ticket->assigned_to)

                @if($ticket->assigned_to == Auth::user()->id)
                    <div class="alert alert-success alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h5><i class="icon fas fa-check"></i> Erfolgreich</h5>
                        Dieses Ticket ist dir zugewiesen.
                    </div>
                @else
                    <div class="alert alert-warning alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h5><i class="icon fas fa-exclamation-triangle"></i> Warnung</h5>
                        Dieses Ticket ist bereits einem Admin zugewiesen.
                    </div>
                @endif
            @else
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h5><i class="icon fas fa-exclamation-triangle"></i> Warnung</h5>
                    Dieses Ticket ist noch keinem Admin zugewiesen.
                </div>
            @endif

            @if(session()->has('success'))
                <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h5><i class="icon fas fa-check"></i> Erfolgreich</h5>
                    {{ session()->get('success') }}
                </div>
            @endif

        </div>
    </div>

    <div class="row">
        <div class="col-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Ticket Aktionen</h3>
                </div>

                <div class="card-body">

                    <!-- ticket antworten -->

                    <form method="POST" action="{{  route('ticket.send', $ticket->id) }}">
                        @csrf
                        <div class="mb-5">
                            <div class="row mb-3">
                                <!-- input to send message -->
                                <div class="col-12">
                                    <label>Ticket antworten</label>

                                    <textarea class="form-control" rows="3" placeholder="Im Ticket antworten" name="content" id="text"></textarea>
                                </div>
                            </div>
        
                            <div class="row">
                                <div class="col-12">
                                    <button type="submit" class="btn btn-block btn-primary">Ticket antworten</button>
                                </div>
                            </div>
                        </div>
                    </form>
                    

                    <hr>

                    <form method="POST" action="{{  route('ticket.update', $ticket->id) }}">
                        <div class="row">
                            <div class="col-12">
                                @csrf
                                @method('PUT')

                                <div class="form-group">
                                    <label>Ticket zuweisen</label>
    
                                    <select class="custom-select" name="assigned_to">
                                        @foreach($admins as $admin)
                                            <option value="{{ $admin->id }}">{{ $admin->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <button type="submit" class="btn btn-block btn-primary">Ticket zuweisen</a>
                            </div>
                        </div>

                    </form>

                    

                    @if(count($templates) > 0)
                        <hr>

                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Globale Vorlagen</label>
                                </div>
                            </div>
                        </div>

                        
                        @foreach($templates as $template)
                            <div class="row">
                                <div class="col-12 mb-3">
                                    <a class="btn btn-block btn-info" onclick="onClick(this)" data-id="{{ $template->id }}">{{ $template->name }}</a>
                                </div>
                            </div>
                        @endforeach
                    @endif

                    <hr>

                    <div class="row">
                        <div class="col-12">

                            <form method="POST" action="{{  route('ticket.destroy', $ticket->id) }}">
                                @csrf
                                @method('POST')
                                <button type="submit" class="btn btn-block btn-danger">Ticket löschen</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Discord Ticket</h3>
                </div>

                <div class="card-body">
                    <div class="timeline">
                        @if(count($messages) > 0)
                            @foreach($messages as $message)
                                <div>
                                    <i class="fas fa-envelope bg-blue"></i>
                                    <div class="timeline-item">
                                        <span class="time">
                                            <i class="fas fa-clock"></i> 
                                            {{ Carbon\Carbon::parse($message->timestamp)->diffForHumans() }} 
                                        </span>
            
                                        <h3 class="timeline-header">
                                            <img src="https://cdn.discordapp.com/avatars/{{ $message->author->id }}/{{ $message->author->avatar }}?size=32" height="32px" width="32px" onerror="this.src='https://cdn.discordapp.com/embed/avatars/0.png?size=32';">
                                            <a href="#">
                                                {{ $message->author->username }}
                                            </a>
                                            schrieb:
                                        </h3>
                                        <div class="timeline-body">
                                            @if($message->attachments)
                                                @foreach($message->attachments as $attachment)
                                                    @if($attachment->content_type == "video/mp4")
                                                        <video controls style="max-width: 100%; max-height: 100%;" class="zoom">
                                                            <source src="{{ $attachment->url }}" type="video/mp4">
                                                        </video>
                                                    @else 
                                                        <img src="{{ $attachment->url }}" style="max-width: 100%; max-height: 100%;" class="zoom">
                                                    @endif

                                                @endforeach

                                                <br>
                                            @endif

                                            <x-markdown>
                                                {{ $message->content }}
                                            </x-markdown>
                                            
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                            <div class="time-label">
                                <span class="bg-green">{{ Carbon\Carbon::parse($message->timestamp) }}</span>
                            </div>
                        @else
                            <p>Es wurden noch keine Nachrichten geschickt</p>
                        @endif
                    </div>
                </div>
            </div>
            
        </div>

    </div>
@endsection

@section('afterscripts')
    <script>

        function onClick(el) {
            const id = $(el).data('id');
            var content = "";

            var templates = {{ Js::from($templates) }}

            console.log(templates)

            for (let i = 0; i < templates.length; i++) {
                if(templates[i].id == id) {
                    content = templates[i].content;
                }
            }

            console.log(content)

            $("#text").val(content);
        }
    </script>
@endsection

