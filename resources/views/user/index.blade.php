@extends('layouts.master')

@section('title', 'Benutzerverwaltung')

@section('content')
    
    <!-- display all users in table -->

    <div class="row">
        <div class="col-12">
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Benutzer</h3>
        </div>
        <!-- /.card-header -->

        <!-- show success message after user was created -->


        <div class="card-body">
            <table id="table" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>E-Mail</th>
                        <th>Erstellt am</th>
                        <th>Aktualisiert am</th>
                        <th>Admin</th>
                        <th>Aktionen</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ Carbon\Carbon::parse($user->created_at)->format('d.m.Y - H:i') }}</td>
                            <td>{{ Carbon\Carbon::parse($user->updated_at)->format('d.m.Y - H:i') }}</td>

                            <td>
                                @if ($user->is_admin)
                                    <span class="badge badge-success">Ja</span>
                                @else
                                    <span class="badge badge-danger">Nein</span>
                                @endif

                            </td>
                            <td>
                                <a href="{{ route('user.edit', $user->id) }}" class="btn btn-primary btn-sm">Bearbeiten</a>
                                <form action="{{ route('user.destroy', $user->id) }}" method="POST" style="display: inline-block;">
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

@endsection 