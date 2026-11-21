<?php

namespace App\Http\Requests\Opportunity;

use App\Models\Opportunity;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MyOpportunityRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'opportunity.tipe' => ['required', Rule::in(array_keys(Opportunity::TIPE))],
            'opportunity.judul' => ['required', 'string', 'max:150'],
            'opportunity.deskripsi' => ['required', 'string'],
            'opportunity.lokasi' => ['nullable', 'string', 'max:100'],
            'opportunity.tanggal_expired' => ['required', 'date', 'after_or_equal:today'],
        ];
    }
}
