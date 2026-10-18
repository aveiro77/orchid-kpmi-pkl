<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Orchid\Platform\Models\Role;


class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $member = [
            'platform.index'            => true,
            'platform.my.profile'       => true,
            'platform.my.skills'        => true,
            'platform.my.businesses'    => true,
            'platform.my.opportunities' => true,
            'platform.my.events'        => true,
        ];

        $pengurus = $member + [
            'platform.dashboard'     => true,
            'platform.members'       => true,
            'platform.opportunities' => true,
            'platform.events'        => true,
        ];

        $admin = $pengurus + [
            'platform.systems.roles'      => true,
            'platform.systems.users'      => true,
            'platform.systems.attachment' => true,
            'platform.skills'             => true,
            'platform.professional-roles' => true,
            'platform.businesses'         => true,
            'platform.referrals'          => true,
        ];

        foreach ([
            'administrator' => ['Administrator', $admin],
            'pengurus'      => ['Pengurus', $pengurus],
            'anggota'       => ['Anggota', $member],
        ] as $slug => [$name, $permissions]) {
            Role::updateOrCreate(['slug' => $slug], ['name' => $name, 'permissions' => $permissions]);
        }
    }
}
