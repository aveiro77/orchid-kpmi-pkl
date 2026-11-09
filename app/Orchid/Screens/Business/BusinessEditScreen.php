<?php

namespace App\Orchid\Screens\Business;

use App\Http\Requests\Business\BusinessRequest;
use App\Models\Business;
use App\Models\Member;
use App\Services\Business\BusinessService;
use Illuminate\Http\RedirectResponse;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\Input;
    use Orchid\Screen\Fields\Select;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class BusinessEditScreen extends Screen
{
    public ?Business $business = null;

    public function query(Business $business): iterable
    {
        if ($business->exists) {
            abort_unless(auth()->user()->can('update', $business), 403);
        }

        return [
            'business' => $business,
        ];
    }

    public function name(): ?string
    {
        return $this->business?->exists ? 'Edit Usaha' : 'Tambah Usaha';
    }

    public function permission(): ?iterable
    {
        return ['platform.businesses'];
    }

    public function commandBar(): iterable
    {
        return [
            Button::make('Simpan')
                ->icon('bs.check-circle')
                ->method('save'),

            Button::make('Hapus')
                ->icon('bs.trash3')
                ->confirm('Usaha ini akan dihapus. Lanjutkan?')
                ->method('remove')
                ->canSee($this->business?->exists ?? false),
        ];
    }

    public function layout(): iterable
    {
        return [
            Layout::rows([
                Select::make('business.member_id')
                    ->title('Pemilik Usaha (Anggota)')
                    ->options(Member::pluck('nama_lengkap', 'id')->toArray())
                    ->required(),

                Input::make('business.nama_usaha')
                    ->title('Nama Usaha')
                    ->required()
                    ->max(150),

                Select::make('business.kategori')
                    ->title('Kategori')
                    ->options(array_combine(config('businesses.categories'), config('businesses.categories')))
                    ->required(),

                TextArea::make('business.deskripsi')
                    ->title('Deskripsi')
                    ->rows(4),

                Input::make('business.alamat')
                    ->title('Alamat'),

                Input::make('business.website')
                    ->title('Website')
                    ->type('url')
                    ->placeholder('https://...'),

                Select::make('business.status')
                    ->title('Status')
                    ->options([
                        'aktif' => 'Aktif',
                        'nonaktif' => 'Nonaktif',
                    ])
                    ->required(),
            ]),
        ];
    }

    public function save(BusinessRequest $request, BusinessService $service, Business $business): RedirectResponse
    {
        if ($business->exists) {
            abort_unless(auth()->user()->can('update', $business), 403);
            $service->update($business, $request->validated()['business']);
            Toast::info('Usaha berhasil diperbarui.');
        } else {
            $service->create($request->validated()['business']);
            Toast::info('Usaha berhasil ditambahkan.');
        }

        return redirect()->route('platform.businesses');
    }

    public function remove(BusinessService $service, Business $business): RedirectResponse
    {
        abort_unless(auth()->user()->can('delete', $business), 403);

        $service->delete($business);
        Toast::info('Usaha berhasil dihapus.');

        return redirect()->route('platform.businesses');
    }
}
