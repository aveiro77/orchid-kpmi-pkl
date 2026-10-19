<?php
// app/Services/MemberService.php
namespace App\Services;

use App\Models\Member;
use Illuminate\Support\Facades\DB;

class MemberService
{
    public function save(Member $member, array $data, array $skillIds = [], array $roleIds = []): Member
    {
        return DB::transaction(function () use ($member, $data, $skillIds, $roleIds) {
            $member->fill($data)->save();
            $member->skills()->sync($skillIds);
            $member->professionalRoles()->sync($roleIds);

            return $member;
        });
    }

    public function delete(Member $member): void
    {
        // DB::transaction(function () use ($member) {
        //     $member->invitations()
        //         ->whereNull('accepted_at')
        //         ->update(['expires_at' => now()]);   // matikan undangan pending

        //     $member->delete();                       // soft delete
        // });
        $member->delete(); // soft delete
    }
}