<?php

namespace App\Orchid\Screens\ProfessionalRole;

use App\Models\ProfessionalRole;
use App\Orchid\Layouts\ProfessionalRole\ProfessionalRoleListLayout;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class ProfessionalRoleListScreen extends Screen
{
    public function query(): iterable
    {
        return [
            'professionalRoles' => ProfessionalRole::withCount('members')
                ->filters()->defaultSort('nama')->paginate(20),
        ];
    }

    public function name(): ?string
    {
        return 'Peran Profesi';
    }

    public function permission(): ?iterable
    {
        return ['platform.professional-roles'];
    }

    public function commandBar(): iterable
    {
        return [
            ModalToggle::make('Tambah Peran Profesi')
                ->icon('bs.plus-circle')
                ->modal('professionalRoleModal')
                ->method('save')
                ->modalTitle('Tambah Peran Profesi'),
        ];
    }

    public function layout(): iterable
    {
        return [
            ProfessionalRoleListLayout::class,

            Layout::modal('professionalRoleModal', Layout::rows([
                Input::make('professionalRole.nama')->title('Nama Peran Profesi')->required(),
            ]))->async('asyncGetProfessionalRole'),
        ];
    }

    public function asyncGetProfessionalRole(ProfessionalRole $professionalRole): iterable
    {
        return ['professionalRole' => $professionalRole];
    }

    public function save(Request $request, ProfessionalRole $professionalRole): void
    {
        $data = $request->validate([
            'professionalRole.nama' => [
                'required', 'string', 'max:100',
                Rule::unique('professional_roles', 'nama')->ignore($professionalRole->id),
            ],
        ]);

        $professionalRole->fill($data['professionalRole'])->save();
        Toast::info('Peran Profesi disimpan.');
    }

    public function remove(Request $request): void
    {
        $role = ProfessionalRole::findOrFail($request->get('id'));

        if ($role->members()->exists()) {
            Toast::error('Peran masih dipakai anggota.');
            return;
        }

        $role->delete();
        Toast::info('Peran Profesi dihapus.');
    }
}
