<?php

namespace App\Orchid\Screens\Opportunity;

use App\Models\Opportunity;
use App\Orchid\Layouts\Opportunity\OpportunityBoardLayout;
use Orchid\Screen\Screen;

class OpportunityBoardScreen extends Screen
{
    public function query(): iterable
    {
        return [
            'opportunities' => Opportunity::with('member')
                ->aktif()
                ->filters()
                ->defaultSort('id', 'desc')
                ->paginate(),
        ];
    }

    public function name(): ?string
    {
        return 'Papan Peluang';
    }

    public function description(): ?string
    {
        return 'Temukan berbagai peluang kerja sama, penawaran, dan kebutuhan dari anggota komunitas.';
    }

    public function commandBar(): iterable
    {
        return [];
    }

    public function layout(): iterable
    {
        return [
            OpportunityBoardLayout::class,
        ];
    }
}
