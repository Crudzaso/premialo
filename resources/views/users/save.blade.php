<!-- usuarios/save.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ isset($user) ? 'Editar Usuario' : 'Agregar Usuario' }}</h1>

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Se encontraron algunos problemas:</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ isset($user) ? route('usuarios.update', $user->id) : route('usuarios.store') }}" method="POST">
        @csrf
        @if(isset($user))
            @method('PUT')
        @endif

        <div class="mb-3">
            <label for="names" class="form-label">Nombres</label>
            <input type="text" class="form-control" id="names" name="names" value="{{ old('names', $user->names ?? '') }}">
        </div>

        <div class="mb-3">
            <label for="lastnames" class="form-label">Apellidos</label>
            <input type="text" class="form-control" id="lastnames" name="lastnames" value="{{ old('lastnames', $user->lastnames ?? '') }}">
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Correo Electrónico</label>
            <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $user->email ?? '') }}">
        </div>

        @if(!isset($user))
            <div class="mb-3">
                <label for="password" class="form-label">Contraseña</label>
                <input type="password" class="form-control" id="password" name="password">
            </div>

            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Confirmar Contraseña</label>
                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
            </div>
        @endif

        <div class="mb-3">
            <label for="address" class="form-label">Dirección</label>
            <input type="text" class="form-control" id="address" name="address" value="{{ old('address', $user->address ?? '') }}">
        </div>

        <div class="mb-3">
            <label for="role" class="form-label">Rol</label>
            <select class="form-control" id="role" name="role">
                <option value="">Selecciona un rol</option>
                @foreach($roles as $role)
                <option value="{{ $role->id }}" {{ old('role', isset($user) && $user->roles->isNotEmpty() ? $user->roles->first()->id : '') == $role->id ? 'selected' : '' }}>
                    {{ $role->name }}
                </option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">{{ isset($user) ? 'Actualizar Usuario' : 'Crear Usuario' }}</button>
        <a href="{{ route('usuarios.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
