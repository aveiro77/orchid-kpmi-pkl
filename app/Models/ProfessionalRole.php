<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfessionalRole extends Model
{
    /** @use HasFactory<\Database\Factories\ProfessionalRoleFactory> */
    use HasFactory;

    public function members()
    {
        return $this->belongsToMany(Member::class, 'member_professional_role');
    }
}
