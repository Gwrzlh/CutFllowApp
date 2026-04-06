@extends('layouts.Admin')
@section('content')

<div>
    <h1>Data Lokasi</h1>
    <a href="{{ route('admin.lokasi.create') }}">Tambah Lokasi</a>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Lokasi</th>
                <th>Kabupaten</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($lokasi as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->Kabupaten }}</td>
                    <td>
                        <a href="{{ route('admin.lokasi.edit', $item->id) }}">Edit</a>
                        <form action="{{ route('admin.lokasi.destroy', $item->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit">Hapus</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection
