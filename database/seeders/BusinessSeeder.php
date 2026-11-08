<?php

namespace Database\Seeders;

use App\Models\Business;
use App\Models\Member;
use Illuminate\Database\Seeder;

class BusinessSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Pastikan ada member untuk relasi
        $member = Member::first();

        if (!$member) {
            $this->command->warn('Tidak ada Member ditemukan. Seeding Business dibatalkan.');
            return;
        }

        Business::updateOrCreate(
            ['nama_usaha' => 'Contoh Usaha Utama'],
            [
                'member_id'  => $member->id,
                'kategori'   => 'Teknologi',
                'deskripsi'  => 'Deskripsi contoh usaha untuk keperluan pengembangan.',
                'alamat'     => 'Jl. Contoh No. 123, Jakarta',
                'website'    => 'https://example.com',
                'status'     => Business::AKTIF,
            ]
        );

        Business::updateOrCreate(
            ['nama_usaha' => 'Toko Kelontong Modern'],
            [
                'member_id'  => $member->id,
                'kategori'   => 'Retail',
                'deskripsi'  => 'Toko dengan konsep modern.',
                'alamat'     => 'Jl. Retail No. 456, Bandung',
                'status'     => Business::AKTIF,
            ]
        );
    }
}
