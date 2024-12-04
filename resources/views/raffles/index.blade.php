@extends('layouts.app')

@section('content')
    <h1>Raffles</h1>
    <a href="{{ route('raffles.create') }}" class="btn btn-primary">Create Raffle</a>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Description</th>
                <th>Price</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($raffles as $raffle)
                <tr>
                    <td>{{ $raffle->id }}</td>
                    <td>{{ $raffle->name }}</td>
                    <td>{{ $raffle->description }}</td>
                    <td>{{ $raffle->price }}</td>
                    <td>{{ $raffle->status }}</td>
                    <td>
                        <a href="{{ route('raffles.edit', $raffle->id) }}" class="btn btn-warning">Edit</a>
                        <form action="{{ route('raffles.destroy', $raffle->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
