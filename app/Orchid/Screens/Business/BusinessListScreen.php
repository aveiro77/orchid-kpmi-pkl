<?php

namespace App\Orchid\Screens\Business;

use App\Models\Business;
use App\Orchid\Layouts\Business\BusinessListLayout;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;

class BusinessListScreen extends Screen
{
    public function query(): iterable
    {
        return [
            'businesses' => Business::with('member')
                ->filters()
                ->defaultSort('id', 'desc')
                ->paginate(20),
        ];
    }

    public function name(): ?string
    {
        return 'Direktori Usaha';
    }

    public function permission(): ?iterable
    {
        return ['platform.businesses'];
    }

    public function commandBar(): iterable
    {
        return [
            Link::make('Tambah Usaha')
                ->icon('bs.plus-circle')
                ->route('platform.businesses.create'),
        ];
    }

    public function layout(): iterable
    {
        return [
            BusinessListLayout::class,
        ];
    }
}
