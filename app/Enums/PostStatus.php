<?php

namespace App\Enums;

enum PostStatus: string
{
    case DRAFT = 'draft';

    case PUBLISHED = 'published';

    public static function all(): array
    {
        return array_column(self::cases(), 'value');
    }
}
