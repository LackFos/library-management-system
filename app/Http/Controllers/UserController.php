<?php

namespace App\Http\Controllers;

use App\Enums\OtpType;
use App\Helpers\ResponseHelper;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\User\UserRegisterRequest;
use App\Http\Requests\User\UserForgotPassword;
use App\Http\Requests\User\UserResetPassword;
use App\Http\Requests\User\UserVerifyRequest;
use App\Mail\SendOtpEmail;
use App\Models\OneTimePassword;
use Illuminate\Http\Request ;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    public function register(UserRegisterRequest $request) {
        try {
            DB::beginTransaction();
            
            $credentials = $request->validated();

            $user = User::create($credentials);
            
            $user['access_token'] = $user->createToken('access_token')->plainTextToken;
            
            $otp = $user->generateOTP(OtpType::VERIFY_ACCOUNT);

            Mail::to($user->email)->send(new SendOtpEmail('Verifikasi Akun - Kode OTP', $user->name, $otp));

            DB::commit();

            return ResponseHelper::returnOkResponse('Account created', $user);
        } catch (\Exception $ex) {
            DB::rollBack();
            return ResponseHelper::throwInternalError($ex->getMessage());
        }
    }

    public function login(Request $request)
    {
        try {
            $isAuthenticated = Auth::attempt([
                'email' => $request['email'],
                'password' => $request['password']
            ]); 

            if (!$isAuthenticated) {
                return ResponseHelper::throwUnauthorizedError('Invalid username or password');
            }
            
            /** @var User $user */
            $user = Auth::user();
            
            $user['access_token'] = $user->createToken('access_token')->plainTextToken;

            return ResponseHelper::returnOkResponse('User logged in', $user);
        } catch (\Throwable $th) {
            return ResponseHelper::throwInternalError($th);
        }
    }

    public function verifyAccount(UserVerifyRequest $request) {
        try {
            DB::beginTransaction();

            $validated = $request->validated();

            $user = $request->user;

            $otp = $user->getVerifyAcountOTP();
            
            if($user->email_verified_at) {
                return ResponseHelper::throwConflictError('User already verified');
            }    

            if(!$otp) {
                return ResponseHelper::throwNotFoundError('OTP not found or expired, please request again');
            }

            if(!Hash::check($validated['otp'], $otp->token)) {
                return ResponseHelper::throwUnauthorizedError('Invalid OTP');
            }

            $user->email_verified_at = now();
            $user->save();

            OneTimePassword::where('email', $user->email)->delete();

            DB::commit();

            return ResponseHelper::returnOkResponse('User verified', $user);
        } catch (\Throwable $th) {
            DB::rollBack();
            return ResponseHelper::throwInternalError($th);
        }
    }

    public function resetPassword(UserResetPassword $request) {
        try{
            DB::beginTransaction();

            $validated = $request->validated();

            $user = User::where('email', $validated['email'])->first();

            $otp = $user->getResetPasswordOTP();

            if(!$otp) {
                return ResponseHelper::throwConflictError('OTP expired, please request again');
            }    

            if(!Hash::check($validated['otp'], $otp->token)) {
                return ResponseHelper::throwUnauthorizedError('Invalid OTP');
            }

            $user->password = Hash::make($validated['password']);
            $user->save();
            
            OneTimePassword::where('email', $user->email)->delete();

            DB::commit();

            return ResponseHelper::returnOkResponse('Password reset successfuly', $user);
        } catch (\Throwable $th) {
            DB::rollBack();
            return ResponseHelper::throwInternalError($th);
        }
    }


    public static function sendVerifyOtp(Request $request) {
        try {
            /** @var User $user */
            $user = Auth::user();

            if(!$user) {
                return ResponseHelper::throwNotFoundError('User not found');
            }

            if($user->email_verified_at) {
                return ResponseHelper::throwConflictError('User already verified');
            }

            $otp = $user->generateOTP(OtpType::VERIFY_ACCOUNT);

            if(!$otp) {
                return ResponseHelper::throwTooManyRequest('You have already requested an OTP recently. Please try again in next 3 minutes');
            }

            Mail::to($user->email)->send(new SendOtpEmail('Verifikasi Akun - Kode OTP',  $user->name, $otp));

            return ResponseHelper::returnOkResponse('OTP sent, please check your email');  
        } catch (\Throwable $th) {
            return ResponseHelper::throwInternalError($th);
        }
    }

    public static function forgotPassword(UserForgotPassword $request) {
        try {
            $validated = $request->validated();

            $user = User::where('email', $validated['email'])->first();

            if(!$user) {
                return ResponseHelper::throwNotFoundError('User not found');
            }
            
            $otp = $user->generateOTP(OtpType::RESET_PASSWORD);

            if(!$otp) {
                return ResponseHelper::throwTooManyRequest('You have already requested an OTP recently. Please try again in next 3 minutes');
            }
            Mail::to($user->email)->send(new SendOtpEmail('Lupa Password - Kode OTP',  $user->name, $otp));

            return ResponseHelper::returnOkResponse('OTP sent, please check your email');
        } catch (\Throwable $th) {
            return ResponseHelper::throwInternalError($th);
        }
    }
}