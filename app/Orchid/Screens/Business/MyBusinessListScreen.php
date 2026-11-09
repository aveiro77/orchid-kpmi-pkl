<?php

namespace App\Orchid\Screens\Business;

use App\Models\Business;
use App\Orchid\Layouts\Business\MyBusinessListLayout;
use App\Services\Business\BusinessService;
use Illuminate\Http\RedirectResponse;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Toast;

class MyBusinessListScreen extends Screen
{
    public function query(): iterable
    {
        $member = auth()->user()?->member;
        abort_if($member === null, 403, 'Akun belum terhubung ke profil anggota. Hubungi Pengurus.');

        return [
            'businesses' => $member->businesses()->paginate(20),
        ];
    }

    public function name(): ?string
    {
        return 'Usaha Saya';
    }

    public function permission(): ?iterable
    {
        return ['platform.my.businesses'];
    }

    public function commandBar(): iterable
    {
        return [
            Link::make('Tambah Usaha')
                ->icon('bs.plus-circle')
                ->route('platform.my.businesses.create'),
        ];
    }

    public function layout(): iterable
    {
        return [
            MyBusinessListLayout::class,
        ];
    }

    public function activate(Business $business, BusinessService $service): RedirectResponse
    {
        abort_unless(auth()->user()->can('update', $business), 403);
        $service->activate($business);
        Toast::info('Status usaha diubah menjadi Aktif.');
        return redirect()->route('platform.my.businesses');
    }

    public function deactivate(Business $business, BusinessService $service): RedirectResponse
    {
        abort_unless(auth()->user()->can('update', $business), 403);
        $service->deactivate($business);
        Toast::info('Status usaha diubah menjadi Nonaktif.');
        return redirect()->route('platform.my.businesses');
    }
}
