<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Enums\OtpType;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    public function generateOTP(OtpType $type): ?string 
    {
        $otp = OneTimePassword::where([
            'email' => $this->email,
            'name' => $type,
        ])->first();

        if ($otp && !$otp->isExpired()) {
            return null;
        }

        $newOTP = strval(rand(100000, 999999));
        
        OneTimePassword::updateOrCreate(
            [
                'email' => $this->email,
                'name' => $type
            ],
            [
                'token' => Hash::make($newOTP),
                'expire_at' => Carbon::now()->addMinutes(3)
            ]
        );
        
        return $newOTP;
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function borrows()
    {
        return $this->hasMany(Borrow::class);
    }

    public function hasRole(string $name)
    {
        return $this->roles()->where('name', $name)->exists();
    }

    private function oneTimePasswords() {
        return $this->hasMany(OneTimePassword::class, 'email', 'email');
    }

    public function getVerifyAcountOTP() {
        return $this->oneTimePasswords()                
            ->where('name', OtpType::VERIFY_ACCOUNT)
            ->where('expire_at', '>', Carbon::now())
            ->first();
    }

    public function getResetPasswordOTP() {
        return $this->oneTimePasswords()
            ->where('name', OtpType::RESET_PASSWORD)
            ->where('expire_at', '>', Carbon::now())
            ->first();
    }

    public function currentAccessToken(): PersonalAccessToken | null
    {
        return $this->hasOne(PersonalAccessToken::class, 'tokenable_id', 'id')->where('name', 'access_token')->first();
    }
}
