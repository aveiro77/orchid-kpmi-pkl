<?php

// app/Orchid/Screens/Skill/SkillListScreen.php
namespace App\Orchid\Screens\Skill;

use App\Models\Skill;
use App\Orchid\Layouts\Skill\SkillListLayout;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;
use Illuminate\Validation\Rule;


class SkillListScreen extends Screen
{
    public function query(): iterable
    {
        return [
            'skills' => Skill::withCount('members')
                ->filters()->defaultSort('nama')->paginate(20),
        ];
    }

    public function name(): ?string { return 'Skill'; }

    public function permission(): ?iterable { return ['platform.skills']; }

    public function commandBar(): iterable
    {
        return [
            ModalToggle::make('Tambah Skill')
                ->icon('bs.plus-circle')
                ->modal('skillModal')
                ->method('save')
                ->modalTitle('Tambah Skill'),
        ];
    }

    public function layout(): iterable
    {
        return [
            SkillListLayout::class,

            Layout::modal('skillModal', Layout::rows([
                Input::make('skill.nama')->title('Nama Skill')->required(),
            ]))->async('asyncGetSkill'),
        ];
    }

    public function asyncGetSkill(Skill $skill): iterable
    {
        return ['skill' => $skill];
    }

    public function save(Request $request, Skill $skill): void
    {
    
        $data = $request->validate([
            'skill.nama' => [
                'required', 'string', 'max:100',
                Rule::unique('skills', 'nama')->ignore($skill->id),
            ],
        ]);

        $skill->fill($data['skill'])->save();
        Toast::info('Skill disimpan.');
    }

    public function remove(Request $request): void
    {
        Skill::findOrFail($request->get('id'))->delete();
        Toast::info('Skill dihapus.');
    }
}