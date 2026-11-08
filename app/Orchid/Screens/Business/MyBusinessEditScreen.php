<?php

namespace App\Orchid\Screens\Business;

use App\Http\Requests\Business\MyBusinessRequest;
use App\Models\Business;
use App\Services\Business\BusinessService;
use Illuminate\Http\RedirectResponse;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class MyBusinessEditScreen extends Screen
{
    public ?Business $business = null;

    public function query(Business $business): iterable
    {
        $member = auth()->user()?->member;
        abort_if($member === null, 403, 'Akun belum terhubung ke profil anggota. Hubungi Pengurus.');

        if ($business->exists) {
            abort_unless($business->member_id === $member->id, 403);
            abort_unless(auth()->user()->can('update', $business), 403);
        }

        return [
            'business' => $business,
        ];
    }

    public function name(): ?string
    {
        return $this->business?->exists ? 'Edit Usaha Saya' : 'Tambah Usaha Saya';
    }

    public function permission(): ?iterable
    {
        return ['platform.my.businesses'];
    }

    public function commandBar(): iterable
    {
        return [
            Button::make('Simpan')
                ->icon('bs.check-circle')
                ->method('save'),
        ];
    }

    public function layout(): iterable
    {
        return [
            Layout::rows([
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
            ]),
        ];
    }

    public function save(MyBusinessRequest $request, BusinessService $service, Business $business): RedirectResponse
    {
        $member = auth()->user()?->member;
        abort_if($member === null, 403, 'Akun belum terhubung ke profil anggota. Hubungi Pengurus.');

        $data = $request->validated()['business'];

        if ($business->exists) {
            abort_unless($business->member_id === $member->id, 403);
            abort_unless(auth()->user()->can('update', $business), 403);
            $service->update($business, $data);
            Toast::info('Usaha berhasil diperbarui.');
        } else {
            $data['member_id'] = $member->id;
            $data['status'] = Business::AKTIF;
            $service->create($data);
            Toast::info('Usaha berhasil ditambahkan.');
        }

        return redirect()->route('platform.my.businesses');
    }
}
