<?php

namespace App\Http\Requests\Business;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MyBusinessRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->member !== null;
    }

    public function rules(): array
    {
        return [
            'business.nama_usaha' => ['required', 'string', 'max:150'],
            'business.kategori' => ['required', Rule::in(config('businesses.categories'))],
            'business.deskripsi' => ['nullable', 'string'],
            'business.alamat' => ['nullable', 'string'],
            'business.website' => ['nullable', 'url', 'max:255'],
        ];
    }
}
