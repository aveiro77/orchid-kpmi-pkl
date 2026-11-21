<?php

namespace App\Services\Opportunity;

use App\Models\Opportunity;
use DomainException;
use Illuminate\Support\Facades\DB;

class OpportunityService
{
    public function create(array $data): Opportunity
    {
        return DB::transaction(function () use ($data) {
            return Opportunity::create($data);
        });
    }

    public function update(Opportunity $opportunity, array $data): Opportunity
    {
        return DB::transaction(function () use ($opportunity, $data) {
            $opportunity->update($data);
            return $opportunity;
        });
    }

    public function publish(Opportunity $opportunity): Opportunity
    {
        if ($opportunity->tanggal_expired && $opportunity->tanggal_expired->endOfDay()->isPast()) {
            throw new DomainException('Tidak dapat mempublikasikan peluang yang sudah kedaluwarsa.');
        }

        return DB::transaction(function () use ($opportunity) {
            $opportunity->update(['status' => Opportunity::PUBLISHED]);
            return $opportunity;
        });
    }

    public function close(Opportunity $opportunity): Opportunity
    {
        return DB::transaction(function () use ($opportunity) {
            $opportunity->update(['status' => Opportunity::CLOSED]);
            return $opportunity;
        });
    }

    public function delete(Opportunity $opportunity): bool
    {
        return DB::transaction(function () use ($opportunity) {
            return $opportunity->delete();
        });
    }
}
