<?php

namespace App\Orchid\Screens\Opportunity;

use App\Models\Opportunity;
use App\Orchid\Layouts\Opportunity\MyOpportunityListLayout;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;

class MyOpportunityListScreen extends Screen
{
    public function query(): iterable
    {
        $member = auth()->user()?->member;
        if (! $member) {
            abort(403, 'Akun belum terhubung ke profil anggota. Hubungi Pengurus.');
        }

        return [
            'opportunities' => $member->opportunities()->filters()->defaultSort('id', 'desc')->paginate(),
        ];
    }

    public function name(): ?string
    {
        return 'Peluang Saya';
    }

    public function commandBar(): iterable
    {
        return [
            Link::make('Tambah')
                ->icon('bs.plus-circle')
                ->route('platform.my.opportunities.create'),
        ];
    }

    public function layout(): iterable
    {
        return [
            MyOpportunityListLayout::class,
        ];
    }
}
