<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class MyProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()?->member !== null;
    }

    public function rules(): array
    {
        return [
            'member.nama_lengkap' => ['required', 'string', 'max:150'],
            'member.foto'         => ['nullable', 'string', 'max:255'],
            'member.nomor_wa'     => ['nullable', 'string', 'max:20'],
            'member.kota'         => ['nullable', 'string', 'max:100'],
            'member.bio'          => ['nullable', 'string', 'max:1000'],
            'member.linkedin'     => ['nullable', 'string', 'max:255'],
            'member.website'      => ['nullable', 'string', 'max:255'],
            'member.instagram'    => ['nullable', 'string', 'max:100'],
        ];
    }
}
