<?php

namespace App\Orchid\Screens\Opportunity;

use App\Http\Requests\Opportunity\MyOpportunityRequest;
use App\Models\Opportunity;
use App\Orchid\Layouts\Opportunity\MyOpportunityEditLayout;
use App\Services\Opportunity\OpportunityService;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;
use Illuminate\Support\Facades\Gate;

class MyOpportunityEditScreen extends Screen
{
    public $opportunity;

    public function query(Opportunity $opportunity): iterable
    {
        $member = auth()->user()->member;
        if (! $member) {
            abort(403, 'Akun belum terhubung ke profil anggota. Hubungi Pengurus.');
        }

        if ($opportunity->exists) {
            if (! Gate::allows('view', $opportunity)) {
                abort(403);
            }
        }

        return [
            'opportunity' => $opportunity,
        ];
    }

    public function name(): ?string
    {
        return $this->opportunity->exists ? 'Edit Peluang' : 'Buat Peluang Baru';
    }

    public function commandBar(): iterable
    {
        $isClosed = $this->opportunity->status === Opportunity::CLOSED;
        $exists = $this->opportunity->exists;

        return [
            Button::make('Simpan')
                ->icon('bs.check-circle')
                ->method('createOrUpdate')
                ->canSee(!$isClosed),

            Button::make('Terbitkan')
                ->icon('bs.send')
                ->method('publish')
                ->canSee($exists && !$isClosed && $this->opportunity->status !== Opportunity::PUBLISHED),

            Button::make('Tutup')
                ->icon('bs.x-circle')
                ->method('close')
                ->canSee($exists && !$isClosed),
        ];
    }

    public function layout(): iterable
    {
        return [
            Layout::block(MyOpportunityEditLayout::class)
                ->title('Detail Peluang')
                ->description('Silakan isi informasi peluang yang ingin Anda bagikan.'),
        ];
    }

    public function createOrUpdate(Opportunity $opportunity, MyOpportunityRequest $request, OpportunityService $service)
    {
        if ($opportunity->exists) {
            if (! Gate::allows('update', $opportunity) || $opportunity->status === Opportunity::CLOSED) {
                abort(403);
            }
        }

        $data = $request->validated()['opportunity'];
        $data['member_id'] = auth()->user()->member->id;

        if (! $opportunity->exists) {
            $data['status'] = Opportunity::DRAFT;
            $service->create($data);
        } else {
            $service->update($opportunity, $data);
        }

        Toast::info('Peluang berhasil disimpan.');
        return redirect()->route('platform.my.opportunities');
    }

    public function publish(Opportunity $opportunity, OpportunityService $service)
    {
        if (! Gate::allows('update', $opportunity) || $opportunity->status === Opportunity::CLOSED) {
            abort(403);
        }

        try {
            $service->publish($opportunity);
            Toast::info('Peluang telah diterbitkan.');
        } catch (\DomainException $e) {
            Toast::error($e->getMessage());
        }

        return redirect()->route('platform.my.opportunities');
    }

    public function close(Opportunity $opportunity, OpportunityService $service)
    {
        if (! Gate::allows('update', $opportunity) || $opportunity->status === Opportunity::CLOSED) {
            abort(403);
        }

        $service->close($opportunity);
        Toast::info('Peluang telah ditutup.');
        return redirect()->route('platform.my.opportunities');
    }
}
