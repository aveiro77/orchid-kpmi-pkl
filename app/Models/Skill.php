<?php

// app/Models/Skill.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Filters\Filterable;
use Orchid\Filters\Types\Like;
use Orchid\Screen\AsSource;

class Skill extends Model
{
    use AsSource, Filterable, HasFactory;

    protected $fillable = ['nama'];

    protected $allowedFilters = ['nama' => Like::class];

    protected $allowedSorts = ['id', 'nama'];

    public function members()
    {
        return $this->belongsToMany(Member::class, 'member_skills');
    }
}
