@extends('layouts.Admin')
@section('content')
    <h1>Update User</h1>
    <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')
        <label for="name">Nama</label>
        <input type="text" name="name" id="name" value="{{ $user->name }}">
        <label for="email">Email</label>
        <input type="email" name="email" id="email" value="{{ $user->email }}">
        <label for="password">Password</label>
        <input type="password" name="password" id="password">
        <label for="role_id">Role</label>
        <select name="role_id" id="role_id">
            @foreach ($role as $item)
                <option value="{{ $item->id }}" {{ $item->id == $user->role_id ? 'selected' : '' }}>{{ $item->name }}</option>
            @endforeach
        </select>
        <button type="submit">Update</button>
    </form>
@endsection