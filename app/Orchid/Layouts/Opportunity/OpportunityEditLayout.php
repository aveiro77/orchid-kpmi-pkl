<?php

namespace App\Orchid\Layouts\Opportunity;

use App\Http\Requests\Opportunity\OpportunityRequest;
use App\Models\Opportunity;
use App\Models\Member;
use Orchid\Screen\Layouts\Rows;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Fields\DateTimer;

class OpportunityEditLayout extends Rows
{
    protected function fields(): iterable
    {
        return [
            Select::make('opportunity.member_id')
                ->fromModel(Member::class, 'nama_lengkap')
                ->title('Pemilik (Member)')
                ->required(),

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
                ->format('Y-m-d'),

            Select::make('opportunity.status')
                ->options([
                    Opportunity::DRAFT => 'Draft',
                    Opportunity::PUBLISHED => 'Published',
                    Opportunity::CLOSED => 'Closed',
                ])
                ->title('Status')
                ->required(),
        ];
    }
}
