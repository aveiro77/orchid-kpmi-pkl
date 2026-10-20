<?php
// app/Orchid/Screens/Profile/MyProfileScreen.php
namespace App\Orchid\Screens\Profile;

use App\Http\Requests\Member\MyProfileRequest;
use App\Models\Member;
use App\Services\Member\MemberService;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\Cropper;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class MyProfileScreen extends Screen
{
    public function name(): ?string
    {
        return 'Profil Saya';
    }

    public function description(): ?string
    {
        return 'Data ini tampil di direktori anggota.';
    }

    public function permission(): ?iterable
    {
        return ['platform.my.profile'];
    }

    public function query(): iterable
    {
        return ['member' => $this->currentMember()];
    }

    public function commandBar(): iterable
    {
        return [
            Button::make('Simpan')->icon('bs.check-circle')->method('save'),
        ];
    }

    public function layout(): iterable
    {
        return [
            Layout::rows([
                Cropper::make('member.foto')
                    ->title('Foto')
                    ->width(400)->height(400)
                    ->targetRelativeUrl(),

                Input::make('member.nama_lengkap')->title('Nama lengkap')->required(),

                Input::make('member.email')
                    ->title('Email')
                    ->readonly()
                    ->help('Untuk mengubah email, hubungi Pengurus.'),

                Input::make('member.nomor_wa')->title('Nomor WhatsApp'),
                Input::make('member.kota')->title('Kota'),
                TextArea::make('member.bio')->title('Bio')->rows(4),
                Input::make('member.linkedin')->title('LinkedIn')->placeholder('https://linkedin.com/in/...'),
                Input::make('member.website')->title('Website')->placeholder('https://...'),
                Input::make('member.instagram')->title('Instagram')->placeholder('@username'),
            ]),
        ];
    }

    public function save(MyProfileRequest $request, MemberService $service)
    {
        // Member diambil ulang dari akun login, BUKAN dari input form.
        $service->updateProfile($this->currentMember(), $request->validated()['member']);

        Toast::info('Profil disimpan.');

        return redirect()->route('platform.my.profile');
    }

    private function currentMember(): Member
    {
        $member = auth()->user()->member;

        abort_if(
            $member === null,
            403,
            'Akun belum terhubung ke profil anggota. Hubungi Pengurus.'
        );

        return $member;
    }
}