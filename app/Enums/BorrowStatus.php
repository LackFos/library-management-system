<?php

namespace App\Enums;

enum BorrowStatus: int
{
    const BORROWING = 1;
    const RETURNED = 2;
}