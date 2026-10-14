<?php
// app/Orchid/Screens/MemberListScreen.php
namespace App\Orchid\Screens\Member;

use App\Models\Member;
use App\Orchid\Layouts\Member\MemberListLayout;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;

class MemberListScreen extends Screen
{
    public function query(): iterable
    {
        return [
            'members' => Member::filters()
                ->defaultSort('id', 'desc')
                ->paginate(15),
        ];
    }

    public function name(): ?string
    {
        return 'Anggota';
    }

    public function description(): ?string
    {
        return 'Direktori seluruh anggota komunitas';
    }

    public function permission(): ?iterable
    {
        return ['platform.members'];
    }

    public function commandBar(): iterable
    {
        return [
            Link::make('Tambah Anggota')
                ->icon('bs.plus-circle')
                ->route('platform.members.create'),
        ];
    }

    public function layout(): iterable
    {
        return [MemberListLayout::class];
    }
}