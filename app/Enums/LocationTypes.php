<?php

namespace App\Enums;

enum LocationTypes :string
{
    case PROVINCE = 'province';
    case CITY = 'city';
    case NATIONAL = 'national';
}
