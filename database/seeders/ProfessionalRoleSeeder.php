<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Orchid\Platform\Models\Role;
use App\Models\ProfessionalRole;

class ProfessionalRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            'pengurus' => ['Pengurus', [
                'platform.index' => true,
                'platform.members' => true,
                'platform.skills' => true,
                'platform.professional-roles' => true,
            ]],
            'anggota' => ['Anggota', [
                'platform.index' => true,
                'platform.member-area' => true,
            ]],
        ];

        foreach ($roles as $slug => [$name, $permissions]) {
            Role::updateOrCreate(['slug' => $slug], [
                'name' => $name,
                'permissions' => $permissions,
            ]);
        }

        // $roles = ['Pengusaha', 'Freelancer', 'Konsultan', 'Mentor', 'Investor',
        //         'Reseller', 'Programmer', 'Designer', 'Marketing'];

        foreach ($roles as $nama) {
            ProfessionalRole::firstOrCreate(['nama' => $nama]);
        }
    }
}
