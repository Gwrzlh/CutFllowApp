@extends('layouts.Admin')
@section('content')
    <h1>Update Role</h1>
    <form action="{{ route('admin.role.update', $role->id) }}" method="POST">
        @csrf
        @method('PUT')
        <label for="name">Nama Role</label>
        <input type="text" name="name" id="name" value="{{ $role->name }}">
        <button type="submit">Update</button>
    </form>
@endsection