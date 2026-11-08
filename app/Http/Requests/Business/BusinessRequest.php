<?php

namespace App\Http\Requests\Business;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BusinessRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->hasAccess('platform.businesses');
    }

    public function rules(): array
    {
        return [
            'business.member_id' => ['required', 'exists:members,id'],
            'business.nama_usaha' => ['required', 'string', 'max:150'],
            'business.kategori' => ['required', Rule::in(config('businesses.categories'))],
            'business.deskripsi' => ['nullable', 'string'],
            'business.alamat' => ['nullable', 'string'],
            'business.website' => ['nullable', 'url', 'max:255'],
            'business.status' => ['required', Rule::in(['aktif', 'nonaktif'])],
        ];
    }
}
