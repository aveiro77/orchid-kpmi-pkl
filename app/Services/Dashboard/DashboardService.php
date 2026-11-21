<?php

namespace App\Services\Dashboard;

use App\Models\Member;
use App\Models\Business;
use App\Models\Opportunity;

class DashboardService
{
    public function totalMembers(): int
    {
        return Member::count();
    }

    public function activeMembers(): int
    {
        return Member::where('status_aktif', true)->count();
    }

    public function activeBusinesses(): int
    {
        return Business::aktif()->count();
    }

    public function activeOpportunities(): int
    {
        return Opportunity::aktif()->count();
    }

    public function memberSummary(Member $member): array
    {
        return [
            'nama'     => $member->nama_lengkap,
            'kota'     => $member->kota,
            'foto'     => $member->foto,
            'email'    => $member->email,
            'nomor_wa' => $member->nomor_wa,
        ];
    }

    public function memberSkillsAndRoles(Member $member): array
    {
        $skills = $member->skills->pluck('nama')->toArray();
        $roles  = $member->professionalRoles->pluck('nama')->toArray();

        return array_merge($skills, $roles);
    }

    public function activeBusinessesOf(Member $member)
    {
        return $member->businesses()->aktif()->get();
    }

    public function opportunitiesOf(Member $member, int $limit = 5)
    {
        return $member->opportunities()->latest()->limit($limit)->get();
    }

    public function latestOpportunitiesForBoard(Member $member, int $limit = 5)
    {
        return Opportunity::with('member')
            ->aktif()
            ->where('member_id', '!=', $member->id)
            ->latest()
            ->limit($limit)
            ->get();
    }

    public function latestOpportunities(int $limit = 5)
    {
        return Opportunity::with('member')->aktif()->latest()->limit($limit)->get();
    }

    // TODO: referral dan event, saat modulnya ada
}
