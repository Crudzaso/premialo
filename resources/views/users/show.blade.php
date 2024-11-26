@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card user-card">
                <div class="card-body">
                    <h4 class="card-title">Detalles del Usuario</h4>
                    <ol>
                        <li><strong>Nombres:</strong> {{ $user->names }}</li>
                        <li><strong>Apellidos:</strong> {{ $user->lastnames }}</li>
                        <li><strong>Correo:</strong> {{ $user->email }}</li>
                        <li><strong>Dirección:</strong> {{ $user->address }}</li>
                        <li><strong>Contraseña:</strong> {{ $user->password }}</li>
                        <li><strong>Role:</strong> {{ $user->roles->isNotEmpty() ? $user->roles->first()->name : 'No asignado' }}</li>
                    </ol>
                    <a href="{{ route('usuarios.index') }}" class="btn btn-secondary">Ir al Index</a>

                    @if($user->trashed())
                        <form action="{{ route('usuarios.restore', $user->id) }}" method="POST" style="display:inline;">
                            @csrf
                            <button type="submit" class="btn btn-success">Restaurar Usuario</button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
