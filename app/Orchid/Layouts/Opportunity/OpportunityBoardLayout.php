<?php

namespace App\Orchid\Layouts\Opportunity;

use App\Models\Opportunity;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;
use Orchid\Screen\Actions\Link;

class OpportunityBoardLayout extends Table
{
    protected $target = 'opportunities';

    protected function columns(): iterable
    {
        return [
            TD::make('judul', 'Judul')
                ->sort()
                ->filter(TD::FILTER_TEXT)
                ->render(fn (Opportunity $opportunity) => Link::make($opportunity->judul)
                    ->route('platform.opportunity-board.show', $opportunity)),

            TD::make('member.nama_lengkap', 'Pemilik')
                ->render(fn (Opportunity $opportunity) => $opportunity->member?->nama_lengkap ?? '-'),

            TD::make('tipe', 'Tipe')
                ->sort()
                ->filter(TD::FILTER_SELECT, Opportunity::TIPE)
                ->render(fn (Opportunity $opportunity) => ucfirst($opportunity->tipe)),

            TD::make('lokasi', 'Lokasi')
                ->render(fn (Opportunity $opportunity) => $opportunity->lokasi ?? '-'),

            TD::make('tanggal_expired', 'Berlaku Hingga')
                ->sort()
                ->render(fn (Opportunity $opportunity) => $opportunity->tanggal_expired?->format('d M Y') ?? '-'),
        ];
    }
}
