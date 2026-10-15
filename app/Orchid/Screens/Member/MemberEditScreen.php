<?php

// app/Orchid/Screens/MemberEditScreen.php
namespace App\Orchid\Screens\Member;

use App\Http\Requests\MemberRequest;
use App\Models\Member;
use App\Services\MemberService;
use Illuminate\Http\RedirectResponse;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Picture;
use Orchid\Screen\Fields\Switcher;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;
use App\Models\ProfessionalRole;
use App\Models\Skill;
use Orchid\Screen\Fields\Relation;

class MemberEditScreen extends Screen
{
    public ?Member $member = null;

    public function query(Member $member): iterable
    {
        $this->member = $member;
        $member->load(['skills', 'professionalRoles']);

        return ['member' => $member];
    }

    public function name(): ?string
    {
        return $this->member?->exists ? 'Edit Anggota' : 'Tambah Anggota';
    }

    public function permission(): ?iterable
    {
        return ['platform.members'];
    }

    public function commandBar(): iterable
    {
        return [
            Button::make('Hapus')
                ->icon('bs.trash3')
                ->confirm('Anggota ini akan dihapus (soft delete). Lanjutkan?')
                ->method('remove')
                ->canSee($this->member?->exists ?? false),

            Button::make('Simpan')
                ->icon('bs.check-circle')
                ->method('save'),
        ];
    }

    public function layout(): iterable
    {
        return [
            Layout::rows([
                Picture::make('member.foto')
                    ->title('Foto')
                    ->targetRelativeUrl(),

                Input::make('member.nama_lengkap')->title('Nama Lengkap')->required(),
                Input::make('member.nomor_wa')->title('Nomor WhatsApp')->mask('9999999999999'),
                Input::make('member.email')->type('email')->title('Email Kontak'),
                Input::make('member.kota')->title('Kota'),
                TextArea::make('member.bio')->title('Bio')->rows(4),
                Input::make('member.linkedin')->title('LinkedIn')->placeholder('https://linkedin.com/in/...'),
                Input::make('member.website')->title('Website'),
                Input::make('member.instagram')->title('Instagram'),
                Switcher::make('member.status_aktif')->sendTrueOrFalse()->title('Status Aktif'),
            ]),
        ];
    }

    public function save(Member $member, MemberRequest $request, MemberService $service): RedirectResponse
    {
        $service->save(
            $member,
            $request->validated()['member'],
            $request->input('member.skills', []),
            $request->input('member.professionalRoles', []),
        );

        Toast::info('Data anggota berhasil disimpan.');

        return redirect()->route('platform.members');
    }

    public function remove(Member $member, MemberService $service): RedirectResponse
    {
        $service->delete($member);

        Toast::info('Anggota berhasil dihapus.');

        return redirect()->route('platform.members');
    }
}
