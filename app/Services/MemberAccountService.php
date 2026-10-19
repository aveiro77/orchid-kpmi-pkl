<?php

// app/Services/Member/MemberAccountService.php

namespace App\Services;

use App\Models\Member;
use App\Models\User;
use DomainException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Orchid\Platform\Models\Role;

class MemberAccountService
{
    public function createAccount(Member $member, string $password): User
    {
        if ($member->user_id) {
            throw new DomainException('Anggota ini sudah punya akun.');
        }
        if (! $member->email) {
            throw new DomainException('Isi email anggota terlebih dahulu.');
        }
        if (User::where('email', $member->email)->exists()) {
            throw new DomainException('Email sudah dipakai akun lain.');
        }

        return DB::transaction(function () use ($member, $password) {
            $user = User::create([
                'name' => $member->nama_lengkap,
                'email' => $member->email,
                'password' => Hash::make($password),
            ]);

            $user->addRole(Role::where('slug', 'anggota')->firstOrFail());

            $member->update(['user_id' => $user->id]);

            return $user;
        });
    }
}
