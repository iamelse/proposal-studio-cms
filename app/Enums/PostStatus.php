<?php

namespace App\Enums;

enum PostStatus: string
{
    case DRAFT = 'draft';
    case PUBLISHED = 'published';
    case ARCHIVED = 'archived';

    public function label(): string
    {
        return match ($this) {
            self::DRAFT => 'Draft',
            self::PUBLISHED => 'Published',
            self::ARCHIVED => 'Archived',
        };
    }

    public function badgeColor(): string
    {
        return match ($this) {
            self::DRAFT => 'bg-yellow-100 text-yellow-800',
            self::PUBLISHED => 'bg-green-100 text-green-800',
            self::ARCHIVED => 'bg-gray-200 text-gray-800',
        };
    }
}
