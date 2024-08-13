<?php

namespace App\Enums;

enum OtpType: string
{
    case VERIFY_ACCOUNT = 'verify_account';
    case RESET_PASSWORD = 'reset_password';
}