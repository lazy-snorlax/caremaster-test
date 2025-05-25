<?php

namespace App\Support\Enums;

enum Role: string
{
    /**
     * Title of the role.
     *
     * @return string
     */
    public function title(): string
    {
        return match ($this) {
            self::Admin => 'Admin',
            self::User => 'User',
        };
    }

    case Admin = 'admin';
    case User = 'user';
}
