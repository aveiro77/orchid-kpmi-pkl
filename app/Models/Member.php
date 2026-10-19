<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Orchid\Filters\Filterable;
use Orchid\Filters\Types\Like;
use Orchid\Filters\Types\Where;
use Orchid\Screen\AsSource;

class Member extends Model
{
    use AsSource, Filterable, HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id', 'nama_lengkap', 'foto', 'nomor_wa', 'email', 'kota',
        'bio', 'linkedin', 'website', 'instagram', 'status_aktif',
    ];

    protected $casts = ['status_aktif' => 'boolean'];

    // Kolom yang boleh difilter dari tabel
    protected $allowedFilters = [
        'nama_lengkap' => Like::class,
        'kota' => Like::class,
        'status_aktif' => Where::class,
    ];

    // Kolom yang boleh di-sort dari tabel
    protected $allowedSorts = [
        'id', 'nama_lengkap', 'kota', 'status_aktif', 'updated_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function skills()
    {
        return $this->belongsToMany(Skill::class, 'member_skills');
    }

    public function professionalRoles()
    {
        return $this->belongsToMany(ProfessionalRole::class, 'member_professional_role');
    }
}
