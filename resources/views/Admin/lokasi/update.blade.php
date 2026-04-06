@extends('layouts.Admin')

@section('content')
    <h1>Update Lokasi</h1>
    <form action="{{ route('admin.lokasi.update', $lokasi->id) }}" method="POST">
        @csrf
        @method('PUT')
        <label for="name">Nama Lokasi</label>
        <input type="text" name="name" id="name" value="{{ $lokasi->name }}">
        <label for="Kabupaten">Kabupaten</label>
        <input type="text" name="Kabupaten" id="Kabupaten" value="{{ $lokasi->Kabupaten }}">
        <button type="submit">Update</button>
    </form>
@endsection
