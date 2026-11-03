<?php

namespace App\Orchid\Screens\Profile;

use App\Models\ProfessionalRole;
use App\Models\Skill;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class MySkillScreen extends Screen
{
    public function name(): ?string
    {
        return 'Keahlian & Peran';
    }

    public function description(): ?string
    {
        return 'Kelola keahlian dan peran profesional Anda.';
    }

    public function permission(): ?iterable
    {
        return ['platform.my.profile'];
    }

    public function query(): iterable
    {
        $member = auth()->user()->member;

        abort_if($member === null, 403, 'Akun belum terhubung ke profil anggota.');

        $member->load(['skills', 'professionalRoles']);

        return ['member' => $member];
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
                Relation::make('member.professionalRoles')
                    ->fromModel(ProfessionalRole::class, 'nama') // Asumsi field nama
                    ->multiple()
                    ->title('Peran Profesional'),

                Relation::make('member.skills')
                    ->fromModel(Skill::class, 'nama')
                    ->multiple()
                    ->title('Keahlian'),
            ]),
        ];
    }

    public function save(Request $request)
    {
        $member = auth()->user()->member;
        $data = $request->input('member');

        $member->skills()->sync($data['skills'] ?? []);
        $member->professionalRoles()->sync($data['professionalRoles'] ?? []);

        Toast::info('Keahlian dan peran berhasil diperbarui.');
    }
}
