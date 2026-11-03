<?php

namespace App\Models;

use Database\Factories\ProfessionalRoleFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Filters\Filterable;
use Orchid\Filters\Types\Like;
use Orchid\Screen\AsSource;

class ProfessionalRole extends Model
{
    /** @use HasFactory<ProfessionalRoleFactory> */
    use AsSource, Filterable, HasFactory;

    protected $fillable = ['nama'];

    protected $allowedFilters = [
        'nama' => Like::class,
    ];

    protected $allowedSorts = [
        'id',
        'nama',
    ];

    public function members()
    {
        return $this->belongsToMany(Member::class, 'member_professional_role');
    }
}
