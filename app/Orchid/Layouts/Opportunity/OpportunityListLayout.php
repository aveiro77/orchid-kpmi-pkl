<?php

namespace App\Orchid\Layouts\Opportunity;

use App\Models\Opportunity;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;
use Orchid\Screen\Actions\Link;

class OpportunityListLayout extends Table
{
    protected $target = 'opportunities';

    protected function columns(): iterable
    {
        return [
            TD::make('judul', 'Judul')
                ->sort()
                ->filter(TD::FILTER_TEXT)
                ->render(fn (Opportunity $opportunity) => Link::make($opportunity->judul)
                    ->route('platform.opportunities.edit', $opportunity)),

            TD::make('member_id', 'Pemilik')
                ->render(fn (Opportunity $opportunity) => $opportunity->member?->nama_lengkap ?? '-'),

            TD::make('tipe', 'Tipe')
                ->sort()
                ->filter(TD::FILTER_SELECT, Opportunity::TIPE)
                ->render(fn (Opportunity $opportunity) => ucfirst($opportunity->tipe)),

            TD::make('status', 'Status')
                ->sort()
                ->filter(TD::FILTER_SELECT, [
                    Opportunity::DRAFT => 'Draft',
                    Opportunity::PUBLISHED => 'Published',
                    Opportunity::CLOSED => 'Closed',
                ])
                ->render(fn (Opportunity $opportunity) => match($opportunity->status) {
                    Opportunity::PUBLISHED => '<span class="text-success">Published</span>',
                    Opportunity::CLOSED => '<span class="text-danger">Closed</span>',
                    default => '<span class="text-muted">Draft</span>',
                }),

            TD::make('tanggal_expired', 'Tanggal Expired')
                ->sort()
                ->render(fn (Opportunity $opportunity) => $opportunity->tanggal_expired?->format('d M Y') ?? '-'),

            TD::make(__('Actions'))
                ->align(TD::ALIGN_CENTER)
                ->width('100px')
                ->render(fn (Opportunity $opportunity) => Link::make(__('Edit'))
                    ->icon('bs.pencil')
                    ->route('platform.opportunities.edit', $opportunity)),
        ];
    }
}
