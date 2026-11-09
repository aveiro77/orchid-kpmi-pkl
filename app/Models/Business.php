<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Orchid\Screen\AsSource;
use Orchid\Filters\Filterable;

class Business extends Model
{
    use AsSource, Filterable, HasFactory, SoftDeletes;

    public const AKTIF = 'aktif';
    public const NONAKTIF = 'nonaktif';

    protected $fillable = ['member_id', 'nama_usaha', 'kategori', 'deskripsi', 'alamat', 'website', 'status'];

    protected $allowedFilters = [
        'nama_usaha' => \Orchid\Filters\Types\Like::class,
        'kategori'   => \Orchid\Filters\Types\Where::class,
        'status'     => \Orchid\Filters\Types\Where::class,
    ];

    protected $allowedSorts = [
        'nama_usaha',
        'kategori',
        'status',
        'updated_at',
    ];

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function scopeAktif($query)
    {
        return $query->where('status', self::AKTIF);
    }
}
