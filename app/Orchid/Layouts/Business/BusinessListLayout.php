<?php

namespace App\Orchid\Layouts\Business;

use App\Models\Business;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class BusinessListLayout extends Table
{
    protected $target = 'businesses';

    protected function columns(): iterable
    {
        return [
            TD::make('nama_usaha', 'Nama Usaha')->sort()->filter(),
            TD::make('member.nama_lengkap', 'Pemilik')->sort(),
            TD::make('kategori', 'Kategori')->sort()->filter(),
            TD::make('status', 'Status')->sort()->filter(),
            TD::make('Aksi')->alignRight()->render(fn (Business $b) => Link::make('Ubah')
                ->icon('bs.pencil')
                ->route('platform.businesses.edit', $b)),
        ];
    }
}
