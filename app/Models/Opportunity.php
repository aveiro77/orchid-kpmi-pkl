<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Orchid\Filters\Filterable;
use Orchid\Filters\Types\Like;
use Orchid\Filters\Types\Where;
use Orchid\Screen\AsSource;

class Opportunity extends Model
{
    use SoftDeletes, Filterable, AsSource;

    public const NEED = 'need';
    public const OFFER = 'offer';
    public const COLLABORATE = 'collaborate';

    public const DRAFT = 'draft';
    public const PUBLISHED = 'published';
    public const CLOSED = 'closed';

    public const TIPE = [
        self::NEED => 'Need',
        self::OFFER => 'Offer',
        self::COLLABORATE => 'Collaborate',
    ];

    protected $fillable = ['member_id', 'tipe', 'judul', 'deskripsi', 'lokasi', 'tanggal_expired', 'status'];

    protected $casts = ['tanggal_expired' => 'date'];

    protected $allowedFilters = [
        'judul' => Like::class,
        'tipe' => Where::class,
        'status' => Where::class,
    ];

    protected $allowedSorts = [
        'id', 'judul', 'tipe', 'status', 'tanggal_expired', 'updated_at',
    ];

    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }

    public function isExpired(): bool
    {
        return $this->tanggal_expired->endOfDay()->isPast();
    }

    public function scopeAktif($query)
    {
        return $query->where('status', self::PUBLISHED)
                     ->whereDate('tanggal_expired', '>=', today());
    }
}
