<?php

namespace App\Models;

use App\Models\Concerns\HasSlug;
use Database\Factories\ProjectFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    /** @use HasFactory<ProjectFactory> */
    use HasFactory, HasSlug, SoftDeletes;

    protected $fillable = [
        'program_id',
        'title',
        'slug',
        'summary',
        'description',
        'image',
        'image_alt',
        'category',
        'beneficiaries_count',
        'is_published',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'beneficiaries_count' => 'integer',
            'is_published' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function program(): BelongsTo
    {
        return $this->belongsTo(Program::class);
    }

    public function scopePublished(Builder $query): void
    {
        $query->where('is_published', true);
    }

    public function scopeOrdered(Builder $query): void
    {
        $query->orderBy('sort_order')->orderBy('title');
    }
}
