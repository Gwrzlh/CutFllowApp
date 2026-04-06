@extends('layouts.Admin')
@section('content')
    <h1>Tambah User</h1>
    <form action="{{ route('admin.users.store') }}" method="POST">
        @csrf
        <label for="name">Nama</label>
        <input type="text" name="name" id="name">
        <label for="email">Email</label>
        <input type="email" name="email" id="email">
        <label for="password">Password</label>
        <input type="password" name="password" id="password">
        <label for="role_id">Role</label>
        <select name="role_id" id="role_id">
            @foreach ($role as $item)
                <option value="{{ $item->id }}">{{ $item->name }}</option>
            @endforeach
        </select>
        <button type="submit">Tambah</button>
    </form>
@endsection