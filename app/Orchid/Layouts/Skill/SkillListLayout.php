<?php

// app/Orchid/Layouts/Skill/SkillListLayout.php
namespace App\Orchid\Layouts\Skill;

use App\Models\Skill;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;
use Orchid\Screen\Fields\Relation;

class SkillListLayout extends Table
{
    protected $target = 'skills';

    protected function columns(): iterable
    {
        return [
            TD::make('nama', 'Skill')->sort()->filter(TD::FILTER_TEXT),

            TD::make('members_count', 'Jumlah Anggota')->sort(),

            TD::make('Aksi')->alignRight()->render(fn (Skill $s) =>
                DropDown::make()->icon('bs.three-dots-vertical')->list([
                    ModalToggle::make('Ubah')
                        ->icon('bs.pencil')
                        ->modal('skillModal')
                        ->method('save')
                        ->modalTitle('Ubah Skill')
                        ->asyncParameters(['skill' => $s->id]),

                    Button::make('Hapus')
                        ->icon('bs.trash3')
                        ->confirm('Hapus skill ini dari semua anggota?')
                        ->method('remove', ['id' => $s->id]),
                ])),

            Relation::make('member.professionalRoles.')
                ->fromModel(ProfessionalRole::class, 'nama')
                ->multiple()
                ->title('Peran Profesi'),

            Relation::make('member.skills.')
                ->fromModel(Skill::class, 'nama')
                ->multiple()
                ->title('Skill'),
        ];
    }
}
