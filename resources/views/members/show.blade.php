@extends('layouts.app')

@section('title', 'Detail Anggota')

@section('content')
    <h1>Detail Anggota</h1>
    <p><a href="{{ route('members.index') }}">&larr; Kembali ke daftar anggota</a></p>

    <table>
        <tbody>
            <tr>
                <th style="width: 200px;">ID</th>
                <td>{{ $member->id }}</td>
            </tr>
            <tr>
                <th>Nama</th>
                <td>{{ $member->nama }}</td>
            </tr>
            <tr>
                <th>NIM</th>
                <td>{{ $member->nim }}</td>
            </tr>
            <tr>
                <th>Email</th>
                <td>{{ $member->email }}</td>
            </tr>
            <tr>
                <th>Nomor Telepon</th>
                <td>{{ $member->nomor_telepon }}</td>
            </tr>
            <tr>
                <th>Alamat</th>
                <td>{{ $member->alamat }}</td>
            </tr>
            <tr>
                <th>Status</th>
                <td>{{ ucfirst($member->status) }}</td>
            </tr>
            <tr>
                <th>Dibuat Pada</th>
                <td>{{ $member->created_at->format('d M Y H:i') }}</td>
            </tr>
        </tbody>
    </table>

    <div style="margin-top: 16px;">
        <a href="{{ route('members.edit', $member->id) }}" class="btn">Edit</a>

        <form action="{{ route('members.destroy', $member->id) }}" method="POST" class="inline"
              onsubmit="return confirm('Yakin ingin menghapus anggota ini?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn" style="background: #dc2626;">Hapus</button>
        </form>
    </div>
@endsection
