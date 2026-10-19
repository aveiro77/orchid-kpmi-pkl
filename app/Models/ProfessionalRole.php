<?php

namespace App\Models;

use Database\Factories\ProfessionalRoleFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfessionalRole extends Model
{
    /** @use HasFactory<ProfessionalRoleFactory> */
    use HasFactory;

    public function members()
    {
        return $this->belongsToMany(Member::class, 'member_professional_role');
    }
}
