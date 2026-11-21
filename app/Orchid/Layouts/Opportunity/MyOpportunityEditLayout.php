<?php

namespace App\Orchid\Layouts\Opportunity;

use App\Models\Opportunity;
use Orchid\Screen\Layouts\Rows;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Fields\DateTimer;

class MyOpportunityEditLayout extends Rows
{
    protected function fields(): iterable
    {
        return [
            Select::make('opportunity.tipe')
                ->options(Opportunity::TIPE)
                ->title('Tipe')
                ->required(),

            Input::make('opportunity.judul')
                ->title('Judul')
                ->max(150)
                ->required(),

            TextArea::make('opportunity.deskripsi')
                ->title('Deskripsi')
                ->rows(5)
                ->required(),

            Input::make('opportunity.lokasi')
                ->title('Lokasi')
                ->max(100),

            DateTimer::make('opportunity.tanggal_expired')
                ->title('Tanggal Expired')
                ->required()
                ->format('Y-m-d')
                ->value($this->query->get('opportunity.tanggal_expired') ?? now()->addDays(30)->format('Y-m-d')),
        ];
    }
}
