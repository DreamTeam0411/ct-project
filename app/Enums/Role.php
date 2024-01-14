<?php

namespace App\Enums;

enum Role: int
{
    case IS_ADMIN = 1;
    case IS_SUPPORT = 2;
    case IS_BUSINESS = 3;
    case IS_CUSTOMER = 4;
}
