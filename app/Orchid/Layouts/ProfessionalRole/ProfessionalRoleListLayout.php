<?php

namespace App\Orchid\Layouts\ProfessionalRole;

use App\Models\ProfessionalRole;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class ProfessionalRoleListLayout extends Table
{
    protected $target = 'professionalRoles';

    protected function columns(): iterable
    {
        return [
            TD::make('nama', 'Peran Profesi')->sort()->filter(TD::FILTER_TEXT),

            TD::make('members_count', 'Jumlah Anggota')->sort(),

            TD::make('Aksi')->alignRight()->render(fn (ProfessionalRole $r) => DropDown::make()->icon('bs.three-dots-vertical')->list([
                ModalToggle::make('Ubah')
                    ->icon('bs.pencil')
                    ->modal('professionalRoleModal')
                    ->method('save')
                    ->modalTitle('Ubah Peran Profesi')
                    ->asyncParameters(['professionalRole' => $r->id]),

                Button::make('Hapus')
                    ->icon('bs.trash3')
                    ->confirm('Hapus peran profesi ini dari semua anggota?')
                    ->method('remove', ['id' => $r->id]),
            ])),
        ];
    }
}
