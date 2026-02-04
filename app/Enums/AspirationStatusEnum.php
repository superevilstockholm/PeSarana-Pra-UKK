<?php

namespace App\Enums;

enum AspirationStatusEnum: string
{
    case PENDING = 'pending';
    case ON_GOING = 'on_going';
    case COMPLETED = 'completed';
    case REJECTED = 'rejected';
}
