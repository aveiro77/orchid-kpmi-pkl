<?php

namespace App\Orchid\Screens\Dashboard;

use App\Services\Dashboard\DashboardService;
use App\Models\Opportunity;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\TD;
use Orchid\Screen\Actions\Link;

class DashboardScreen extends Screen
{
    protected DashboardService $service;

    public function __construct(DashboardService $service)
    {
        $this->service = $service;
    }

    public function query(DashboardService $service): iterable
    {
        return [
            'total_members'        => $service->totalMembers(),
            'active_members'       => $service->activeMembers(),
            'active_businesses'    => $service->activeBusinesses(),
            'active_opportunities' => $service->activeOpportunities(),
            'opportunities'        => $service->latestOpportunities(5),
        ];
    }

    public function name(): ?string
    {
        return 'Dashboard';
    }

    public function commandBar(): iterable
    {
        return [];
    }

    public function layout(): iterable
    {
        return [
            Layout::metrics([
                'Total Anggota'    => 'total_members',
                'Anggota Aktif'    => 'active_members',
                'Usaha Aktif'      => 'active_businesses',
                'Peluang Aktif'    => 'active_opportunities',
            ]),

            Layout::table('opportunities', [
                TD::make('judul', 'Judul')
                    ->render(fn (Opportunity $o) => Link::make($o->judul)->route('platform.opportunity-board.show', $o)),
                TD::make('tipe', 'Tipe')
                    ->render(fn (Opportunity $o) => ucfirst($o->tipe)),
                TD::make('member.nama_lengkap', 'Pemilik'),
                TD::make('tanggal_expired', 'Berlaku Hingga')
                    ->render(fn (Opportunity $o) => $o->tanggal_expired?->format('d M Y')),
            ]),
        ];
    }
}
