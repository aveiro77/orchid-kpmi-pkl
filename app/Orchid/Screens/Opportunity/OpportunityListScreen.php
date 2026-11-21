<?php

namespace App\Orchid\Screens\Opportunity;

use App\Models\Opportunity;
use App\Orchid\Layouts\Opportunity\OpportunityListLayout;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;

class OpportunityListScreen extends Screen
{
    public function query(): iterable
    {
        return [
            'opportunities' => Opportunity::filters()->defaultSort('id', 'desc')->paginate(),
        ];
    }

    public function name(): ?string
    {
        return 'Daftar Peluang';
    }

    public function commandBar(): iterable
    {
        return [
            Link::make('Tambah')
                ->icon('bs.plus-circle')
                ->route('platform.opportunities.create'),
        ];
    }

    public function layout(): iterable
    {
        return [
            OpportunityListLayout::class,
        ];
    }
}
