<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreMemberRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        // On update, ignore the current member's own nim/email in unique check
        $memberId = $this->route('member');

        return [
            'nama'          => 'required|string|max:100',
            'nim'           => 'required|string|max:20|unique:members,nim,' . $memberId,
            'email'         => 'required|email|max:100|unique:members,email,' . $memberId,
            'nomor_telepon' => 'required|string|max:20',
            'alamat'        => 'required|string',
            'status'        => 'required|in:aktif,nonaktif',
        ];
    }

    public function messages(): array
    {
        return [
            'nama.required'          => 'Nama anggota wajib diisi.',
            'nama.max'               => 'Nama anggota maksimal 100 karakter.',
            'nim.required'           => 'NIM wajib diisi.',
            'nim.unique'             => 'NIM tersebut sudah digunakan oleh anggota lain.',
            'nim.max'                => 'NIM maksimal 20 karakter.',
            'email.required'         => 'Email wajib diisi.',
            'email.email'            => 'Format email tidak valid.',
            'email.unique'           => 'Email tersebut sudah digunakan oleh anggota lain.',
            'email.max'              => 'Email maksimal 100 karakter.',
            'nomor_telepon.required' => 'Nomor telepon wajib diisi.',
            'nomor_telepon.max'      => 'Nomor telepon maksimal 20 karakter.',
            'alamat.required'        => 'Alamat wajib diisi.',
            'status.required'        => 'Status wajib dipilih.',
            'status.in'              => 'Status harus salah satu dari: aktif, nonaktif.',
        ];
    }
}