@extends('layouts.master')

@section('title', 'Dashboard')

@section('content')
    <div class="row">
        <div class="col-12">
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
        </div>
    </div>

    <div class="row">
        <!-- show widget open tickets for logged in user -->
        <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box bg-gradient-info">
                <span class="info-box-icon"><i class="far fa-envelope"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Deine offenen Tickets</span>
                    <span class="info-box-number">{{ $open_tickets }}</span>
                    @if($open_tickets != 0 && $all_tickets != 0)
                        <div class="progress">
                            <div class="progress-bar" style="width: {{ number_format($open_tickets / $all_tickets * 100) }}%"></div>
                        </div>
                    @endif
                </div>

            </div>
        </div>

        <!-- count user -->

        <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box bg-gradient-success">
                <span class="info-box-icon"><i class="far fa-flag"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Tickets (insgesamt)</span>
                    <span class="info-box-number">{{ $all_tickets }}</span>
                    <div class="progress">
                        <div class="progress-bar" style="width: 100%"></div>
                    </div>
                </div>

            </div>
        </div>

        <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box bg-gradient-danger">
                <span class="info-box-icon"><i class="fas fa-user"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Benutzer</span>
                    <span class="info-box-number">{{ $user_count }}</span>
                    <div class="progress">
                        <div class="progress-bar" style="width: 100%"></div>
                    </div>
                </div>

            </div>

        </div>

    </div>
@endsection
