@extends('layouts.Admin')

@section('content')
    <h1>Tambah Lokasi</h1>
    <form action="{{ route('admin.lokasi.store') }}" method="POST">
        @csrf
        <label for="name">Nama Lokasi</label>
        <input type="text" name="name" id="name">
        <label for="Kabupaten">Kabupaten</label>
        <input type="text" name="Kabupaten" id="Kabupaten">
        <button type="submit">Tambah</button>
    </form>
@endsection