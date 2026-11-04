<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MemberRequest extends FormRequest
{
    // app/Http/Requests/MemberRequest.php
    public function authorize(): bool
    {
        return $this->user()->hasAccess('platform.members');
    }

    public function rules(): array
    {
        return [
            'member.nama_lengkap' => ['required', 'string', 'max:255'],
            'member.nomor_wa' => ['nullable', 'string', 'max:20'],
            'member.email' => ['nullable', 'email', 'max:255'],
            'member.kota' => ['nullable', 'string', 'max:100'],
            'member.bio' => ['nullable', 'string', 'max:2000'],
            'member.linkedin' => ['nullable', 'string', 'max:255'],
            'member.website' => ['nullable', 'string', 'max:255'],
            'member.instagram' => ['nullable', 'string', 'max:100'],
            'member.foto' => ['nullable', 'string'],
            'member.status_aktif' => ['boolean'],
            'member.skills' => ['array'],
            'member.skills.*' => ['exists:skills,id'],
            'member.professionalRoles' => ['array'],
            'member.professionalRoles.*' => ['exists:professional_roles,id'],
        ];
    }
}
