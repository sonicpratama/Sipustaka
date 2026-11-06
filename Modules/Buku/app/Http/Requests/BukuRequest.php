<?php

namespace Modules\Buku\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BukuRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isAdmin() ?? false;
    }

    public function rules(): array
    {
        return [
            'judul'        => ['required', 'string', 'max:150'],
            'penulis'      => ['required', 'string', 'max:100'],
            'penerbit'     => ['required', 'string', 'max:100'],
            'tahun_terbit' => ['required', 'integer', 'min:1900', 'max:' . date('Y')],
            'stok'         => ['required', 'integer', 'min:0'],
        ];
    }

    public function messages(): array
    {
        return [
            'judul.required'        => 'Judul buku wajib diisi.',
            'judul.max'             => 'Judul maksimal 150 karakter.',
            'penulis.required'      => 'Penulis wajib diisi.',
            'penerbit.required'     => 'Penerbit wajib diisi.',
            'tahun_terbit.required' => 'Tahun terbit wajib diisi.',
            'tahun_terbit.integer'  => 'Tahun terbit harus berupa angka.',
            'tahun_terbit.min'      => 'Tahun terbit minimal 1900.',
            'tahun_terbit.max'      => 'Tahun terbit tidak boleh melebihi tahun ini.',
            'stok.required'         => 'Stok wajib diisi.',
            'stok.integer'          => 'Stok harus berupa angka.',
            'stok.min'              => 'Stok tidak boleh kurang dari 0.',
        ];
    }
}
