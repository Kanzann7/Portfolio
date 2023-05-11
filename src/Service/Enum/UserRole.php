<?php

namespace App\Service\Enum;

enum UserRole: string
{
    case ADMIN = 'admin';
    case USER = 'user';
}
