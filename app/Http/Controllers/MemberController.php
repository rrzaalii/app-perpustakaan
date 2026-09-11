<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMemberRequest;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    private array $members = [
        ['id' => 1, 'nama' => 'Ahmad Fauzi', 'nim' => '2141720001', 'email' => 'fauzi@example.com', 'nomor_telepon' => '081234567890', 'alamat' => 'Jl. Merdeka No. 1, Surabaya', 'status' => 'aktif'],
        ['id' => 2, 'nama' => 'Siti Rahma', 'nim' => '2141720002', 'email' => 'rahma@example.com', 'nomor_telepon' => '081234567891', 'alamat' => 'Jl. Diponegoro No. 5, Surabaya', 'status' => 'aktif'],
        ['id' => 3, 'nama' => 'Budi Santoso', 'nim' => '2141720003', 'email' => 'budi@example.com', 'nomor_telepon' => '081234567892', 'alamat' => 'Jl. Kartini No. 9, Surabaya', 'status' => 'nonaktif'],
    ];

    public function index()
    {
        $members = $this->members;

        return view('members.index', compact('members'));
    }

    public function create()
    {
        return view('members.create');
    }

    public function store(StoreMemberRequest $request)
    {
        $validated = $request->validated();

        return redirect()->route('members.index')
            ->with('success', "Anggota \"{$validated['nama']}\" berhasil ditambahkan (data dummy, belum tersimpan ke database).");
    }

    public function show(string $id)
    {
        return "MemberController@show, id: {$id}";
    }

    public function edit(string $id)
    {
        return "MemberController@edit, id: {$id}";
    }

    public function update(Request $request, string $id)
    {
        return "MemberController@update, id: {$id}";
    }

    public function destroy(string $id)
    {
        return "MemberController@destroy, id: {$id}";
    }
}