<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMemberRequest;
use App\Models\Member;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    public function index()
    {
        $members = Member::when(request('search'), function ($query, $search) {
            $query->where('nama', 'like', "%{$search}%");
        })->paginate(10);

        return view('members.index', compact('members'));
    }

    public function create()
    {
        return view('members.create');
    }

    public function store(StoreMemberRequest $request)
    {
        $validated = $request->validated();
        $member = Member::create($validated);

        return redirect()->route('members.index')
            ->with('success', "Anggota \"{$member->nama}\" berhasil ditambahkan.");
    }

    public function show(string $id)
    {
        $member = Member::findOrFail($id);

        return view('members.show', compact('member'));
    }

    public function edit(string $id)
    {
        $member = Member::findOrFail($id);

        return view('members.edit', compact('member'));
    }

    public function update(StoreMemberRequest $request, string $id)
    {
        $member = Member::findOrFail($id);
        $validated = $request->validated();
        $member->update($validated);

        return redirect()->route('members.index')
            ->with('success', "Anggota \"{$member->nama}\" berhasil diperbarui.");
    }

    public function destroy(string $id)
    {
        $member = Member::findOrFail($id);
        $nama = $member->nama;
        $member->delete();

        return redirect()->route('members.index')
            ->with('success', "Anggota \"{$nama}\" berhasil dihapus.");
    }
}