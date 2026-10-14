<?php
// app/Services/MemberService.php
namespace App\Services;

use App\Models\Member;

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
        $member->delete(); // soft delete
    }
}