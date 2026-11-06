<?php

namespace Modules\UserManagement\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isAdmin() ?? false;
    }

    /** True jika admin sedang mengubah akunnya sendiri. */
    private function editingSelf(): bool
    {
        $target = $this->route('user');

        return $target && $target->id === $this->user()->id;
    }

    public function rules(): array
    {
        $target = $this->route('user'); // null saat tambah

        // Admin tidak boleh menurunkan role akunnya sendiri
        $roleRule = $this->editingSelf()
            ? ['required', Rule::in(['admin'])]
            : ['required', Rule::in(['admin', 'user'])];

        return [
            'name'     => ['required', 'string', 'max:100'],
            'email'    => ['required', 'email', 'max:150', Rule::unique('users', 'email')->ignore($target?->id)],
            'role'     => $roleRule,
            'password' => $target
                ? ['nullable', 'string', 'min:8', 'confirmed']
                : ['required', 'string', 'min:8', 'confirmed'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'      => 'Nama wajib diisi.',
            'email.required'     => 'Email wajib diisi.',
            'email.email'        => 'Format email tidak valid.',
            'email.unique'       => 'Email sudah digunakan.',
            'role.required'      => 'Role wajib dipilih.',
            'role.in'            => $this->editingSelf()
                ? 'Anda tidak dapat menurunkan role akun Anda sendiri.'
                : 'Role tidak valid.',
            'password.required'  => 'Password wajib diisi.',
            'password.min'       => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ];
    }
}
