<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(MemberSeeder::class);
        $this->call(RoleSeeder::class);
        $this->call(SkillSeeder::class);

        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'permissions' => [
                // SEMUA PERMISSION UNTUK ADMIN
                'platform.index' => true,
                'platform.systems' => true,
                'platform.systems.roles' => true,
                'platform.systems.users' => true,
                'platform.systems.attachment' => true,
                'platform.skills' => true,
                'platform.professional-roles' => true,
                'platform.businesses' => true,
                'platform.referrals' => true,
                'platform.members' => true,
                'platform.opportunities' => true,
                'platform.events' => true,
            ],
        ]);
    }
}
