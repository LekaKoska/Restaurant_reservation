<?php

namespace App\Enums;

enum TableStatus: string
{
    case Pending = "pending";
    case Confirmed = "confirmed";
    case Cancel = "cancel";
}
