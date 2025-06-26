<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PostViewStatistic extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'date' => 'date',
    ];

    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }

    // Scope untuk ambil data 7 hari terakhir
    public function scopeLast7Days(Builder $query): Builder
    {
        return $query->where('date', '>=', now()->subDays(6)->startOfDay());
    }

    // Scope untuk filter post tertentu
    public function scopeForPost(Builder $query, int $postId): Builder
    {
        return $query->where('post_id', $postId);
    }
}
