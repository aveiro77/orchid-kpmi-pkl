<?php

namespace App\Orchid\Screens\Opportunity;

use App\Http\Requests\Opportunity\OpportunityRequest;
use App\Models\Opportunity;
use App\Orchid\Layouts\Opportunity\OpportunityEditLayout;
use App\Services\Opportunity\OpportunityService;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class OpportunityEditScreen extends Screen
{
    public $opportunity;

    public function query(Opportunity $opportunity): iterable
    {
        return ['opportunity' => $opportunity];
    }

    public function name(): ?string
    {
        return $this->opportunity->exists ? 'Edit Peluang' : 'Buat Peluang';
    }

    public function commandBar(): iterable
    {
        return [
            Button::make('Simpan')
                ->icon('bs.check-circle')
                ->method('createOrUpdate'),
        ];
    }

    public function layout(): iterable
    {
        return [
            Layout::block(OpportunityEditLayout::class)
                ->title('Informasi Peluang'),
        ];
    }

    public function createOrUpdate(Opportunity $opportunity, OpportunityRequest $request, OpportunityService $service)
    {
        $data = $request->validated()['opportunity'];
        
        if ($opportunity->exists) {
            $service->update($opportunity, $data);
        } else {
            $service->create($data);
        }

        Toast::info('Peluang berhasil disimpan.');
        return redirect()->route('platform.opportunities');
    }
}
