<?php

namespace App\Orchid\Screens\Dashboard;

use App\Services\Dashboard\DashboardService;
use App\Models\Opportunity;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\TD;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Fields\Label;

class MyDashboardScreen extends Screen
{
    public function query(DashboardService $service): iterable
    {
        $member = auth()->user()?->member;
        
        if (!$member) {
            abort(403, 'Akun belum terhubung ke profil anggota. Hubungi Pengurus.');
        }

        return [
            'summary'       => $service->memberSummary($member),
            'skills_roles'  => $service->memberSkillsAndRoles($member),
            'businesses'    => $service->activeBusinessesOf($member),
            'opportunities' => $service->opportunitiesOf($member, 5),
            'board_latest'  => $service->latestOpportunitiesForBoard($member, 5),
        ];
    }

    public function name(): ?string
    {
        return 'Dashboard Saya';
    }

    public function layout(): iterable
    {
        return [
            Layout::rows([
                Group::make([
                    Label::make('summary.nama')->title('Nama'),
                    Label::make('summary.email')->title('Email'),
                    Label::make('summary.nomor_wa')->title('WhatsApp'),
                ]),
            ])->title('Profil Singkat'),

            Layout::view('dashboard.skills', [
                'skills' => 'skills_roles',
            ]),

            Layout::table('businesses', [
                TD::make('judul', 'Nama Usaha'),
                TD::make('kategori', 'Kategori'),
            ])->title('Usaha Aktif Saya'),

            Layout::table('opportunities', [
                TD::make('judul', 'Judul'),
                TD::make('status', 'Status'),
                TD::make('tanggal_expired', 'Berlaku Hingga'),
            ])->title('Peluang Saya'),

            Layout::table('board_latest', [
                TD::make('judul', 'Judul')
                    ->render(fn (Opportunity $o) => Link::make($o->judul)->route('platform.opportunity-board.show', $o)),
                TD::make('tipe', 'Tipe'),
                TD::make('member.nama_lengkap', 'Pemilik'),
            ])->title('Peluang Terbaru dari Anggota Lain'),
        ];
    }
}
