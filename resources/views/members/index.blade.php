{{-- File: resources/views/members/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Daftar Anggota')

@section('content')
    <h1>Daftar Anggota</h1>

    {{-- Search Form --}}
    <form method="GET" action="{{ route('members.index') }}" style="margin-bottom: 16px; display: flex; gap: 8px;">
        <input type="text" name="search" placeholder="Cari nama anggota..."
               value="{{ request('search') }}" style="max-width: 300px;">
        <button type="submit" class="btn">Cari</button>
        @if(request('search'))
            <a href="{{ route('members.index') }}" class="btn" style="background: #6b7280;">Reset</a>
        @endif
    </form>

    <p>
        <a href="{{ route('members.create') }}" class="btn">+ Tambah Anggota</a>
    </p>

    @if(request('search'))
        <p>Menampilkan hasil pencarian untuk: <strong>{{ request('search') }}</strong></p>
    @endif

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama</th>
                <th>NIM</th>
                <th>Email</th>
                <th>No. Telepon</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($members as $member)
                <tr>
                    <td>{{ $member->id }}</td>
                    <td>{{ $member->nama }}</td>
                    <td>{{ $member->nim }}</td>
                    <td>{{ $member->email }}</td>
                    <td>{{ $member->nomor_telepon }}</td>
                    <td>{{ ucfirst($member->status) }}</td>
                    <td>
                        <a href="{{ route('members.show', $member->id) }}" class="btn" style="font-size:13px; padding:4px 10px;">Detail</a>
                        <a href="{{ route('members.edit', $member->id) }}" class="btn" style="font-size:13px; padding:4px 10px; background:#f59e0b;">Edit</a>
                        <form action="{{ route('members.destroy', $member->id) }}" method="POST" class="inline"
                              onsubmit="return confirm('Yakin ingin menghapus anggota ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn" style="font-size:13px; padding:4px 10px; background:#dc2626;">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7">
                        @if(request('search'))
                            Tidak ada anggota dengan nama "<strong>{{ request('search') }}</strong>".
                        @else
                            Belum ada data anggota.
                        @endif
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{-- Pagination with search param preserved --}}
    <div style="margin-top: 16px;">
        {{ $members->appends(request()->query())->links() }}
    </div>
@endsection