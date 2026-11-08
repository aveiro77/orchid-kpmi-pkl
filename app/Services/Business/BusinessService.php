<?php

namespace App\Services\Business;

use App\Models\Business;
use Illuminate\Support\Facades\DB;

class BusinessService
{
    public function create(array $data): Business
    {
        return Business::create($data);
    }

    public function update(Business $business, array $data): Business
    {
        $business->fill($data)->save();
        return $business;
    }

    public function activate(Business $business): void
    {
        $business->update(['status' => Business::AKTIF]);
    }

    public function deactivate(Business $business): void
    {
        $business->update(['status' => Business::NONAKTIF]);
    }

    public function delete(Business $business): void
    {
        $business->delete();
    }
}
