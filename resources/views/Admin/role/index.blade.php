@extends('layouts.Admin')
@section('content')
    <h1>Data Role</h1>
    <a href="{{ route('admin.role.create') }}">Tambah Role</a>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Role</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($role as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->name }}</td>
                    <td>
                        <a href="{{ route('admin.role.edit', $item->id) }}">Edit</a>
                        <form action="{{ route('admin.role.destroy', $item->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit">Hapus</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection