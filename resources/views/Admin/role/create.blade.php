@extends('layouts.Admin')
@section('content')
    <h1>Tambah Role</h1>
    <form action="{{ route('admin.role.store') }}" method="POST">
        @csrf
        <label for="name">Nama Role</label>
        <input type="text" name="name" id="name">
        <button type="submit">Tambah</button>
    </form>
@endsection