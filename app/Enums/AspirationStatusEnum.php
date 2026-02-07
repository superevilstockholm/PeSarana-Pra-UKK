<?php

namespace App\Enums;

enum AspirationStatusEnum: string
{
    case PENDING = 'pending';
    case ON_GOING = 'on_going';
    case COMPLETED = 'completed';
    case REJECTED = 'rejected';

    public function label(): string
    {
        if ($this === self::PENDING) return 'Menunggu';
        if ($this === self::ON_GOING) return 'Diproses';
        if ($this === self::COMPLETED) return 'Selesai';
        if ($this === self::REJECTED) return 'Ditolak';
        else return '-';
    }
}
