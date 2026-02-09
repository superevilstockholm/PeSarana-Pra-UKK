<?php

namespace App\Enums;

enum RoleEnum: string
{
    case ADMIN = 'admin';
    case STUDENT = 'student';

    public function label(): string
    {
        if ($this === self::ADMIN) {
            return 'Admin';
        } else if ($this === self::STUDENT) {
            return 'Siswa';
        } else {
            return '-';
        }
    }
}
