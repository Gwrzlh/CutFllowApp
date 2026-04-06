@extends('layouts.Admin')
@section('content')
    <h1>Data User</h1>
    <a href="{{ route('admin.users.create') }}">Tambah User</a>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Role</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($user as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->email }}</td>
                    <td>{{ $item->role->name }}</td>
                    <td>
                        <a href="{{ route('admin.users.edit', $item->id) }}">Edit</a>
                        <form action="{{ route('admin.users.destroy', $item->id) }}" method="POST">
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