<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Yogameleniawan\SearchSortEloquent\Traits\Searchable;
use Yogameleniawan\SearchSortEloquent\Traits\Sortable;

class FAQ extends Model
{
    use HasFactory, Searchable, Sortable;

    protected $guarded = ['id'];

    /**
     * Get the formmated why us created_at.
     * @return Attribute
     */
    protected function formattedCreatedAt(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->created_at
                ? Carbon::parse($this->created_at)->format('d M, Y H:i')
                : '[null]'
        );
    }

    /**
     * Get the formmated why us updated_at.
     * @return Attribute
     */
    protected function formattedUpdatedAt(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->updated_at
                ? Carbon::parse($this->updated_at)->format('d M, Y H:i')
                : '[null]'
        );
    }
}
