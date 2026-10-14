<?php

// app/Orchid/Layouts/MemberListLayout.php
namespace App\Orchid\Layouts\Member;

use App\Models\Member;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class MemberListLayout extends Table
{
    protected $target = 'members'; // sama dengan key di query() Screen

    protected function columns(): iterable
    {
        return [
            TD::make('nama_lengkap', 'Nama')
                ->sort()->filter(TD::FILTER_TEXT)
                ->render(fn (Member $m) => Link::make($m->nama_lengkap)
                    ->route('platform.members.edit', $m)),

            TD::make('kota', 'Kota')->sort()->filter(TD::FILTER_TEXT),

            TD::make('nomor_wa', 'WhatsApp'),

            TD::make('status_aktif', 'Status')->sort()
                ->render(fn (Member $m) => $m->status_aktif ? 'Aktif' : 'Non Aktif'),

            TD::make('updated_at', 'Diperbarui')->sort()
                ->render(fn (Member $m) => $m->updated_at->diffForHumans()),
        ];
    }
}