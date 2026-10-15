<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Skill;

class SkillSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $skills = ['Web Development', 'Graphic Design', 'Accounting',
                'Digital Marketing', 'Photography', 'Legal Consultant'];

        foreach ($skills as $nama) {
            Skill::firstOrCreate(['nama' => $nama]);
        }
    }
}
