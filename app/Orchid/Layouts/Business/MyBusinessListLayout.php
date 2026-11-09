<?php

namespace App\Orchid\Layouts\Business;

use App\Models\Business;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class MyBusinessListLayout extends Table
{
    protected $target = 'businesses';

    protected function columns(): iterable
    {
        return [
            TD::make('nama_usaha', 'Nama Usaha'),
            TD::make('kategori', 'Kategori'),
            TD::make('status', 'Status')->render(fn (Business $business) => ucfirst($business->status)),
            TD::make('Aksi')->alignRight()->render(fn (Business $business) => Link::make('Ubah')
                ->icon('bs.pencil')
                ->route('platform.my.businesses.edit', $business)),
            TD::make('Toggle')->alignRight()->render(function (Business $business) {
                if ($business->status === Business::AKTIF) {
                    return Button::make('Nonaktifkan')
                        ->icon('bs.eye-slash')
                        ->method('deactivate', ['business' => $business->id]);
                }

                return Button::make('Aktifkan')
                    ->icon('bs.eye')
                    ->method('activate', ['business' => $business->id]);
            }),
        ];
    }
}
