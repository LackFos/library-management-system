<?php

namespace App\Models;

use App\Enums\OtpType;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class OneTimePassword extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $guarded = ['id'];

    public function isExpired(): bool 
    {
        return $this->expire_at < Carbon::now();
    }
}