<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Models\User;
use App\Http\Helpers;
use App\Http\Requests\ResetPasswordRequest;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\User\UserLoginRequest;
use App\Http\Requests\User\UserRegisterRequest;
use App\Http\Requests\VerifyAccountRequest;
use App\Models\OneTimePassword;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function register(UserRegisterRequest $request) {
        try {
            DB::beginTransaction();
            
            $credentials = $request->validated();

            $user = User::create($credentials);
            
            $user['access_token'] = $user->createToken('access_token')->plainTextToken;
            
            DB::commit();

            return ResponseHelper::returnOkResponse('Account created', $user);
        } catch (\Exception $ex) {
            DB::rollBack();
            return ResponseHelper::throwInternalError($ex->getMessage());
        }
    }

    public function login(UserLoginRequest $request)
    {
        try {
            $credentials = $request->validated();
            $isAuthenticated = Auth::attempt($credentials);
            
            if (!$isAuthenticated) {
                return ResponseHelper::throwNotFoundError('Invalid username or password');
            }
                    
            /** @var User $user */
            $user = auth()->user();
            
            $user->currentAccessToken()?->delete();

            $token = $user->createToken('access_token')->plainTextToken;

            $user['access_token'] = $token;

            return ResponseHelper::returnOkResponse('User logged in', $user);
        } catch (\Throwable $th) {
            return ResponseHelper::throwInternalError($th);
        }
    }

    // public function verifyAccount(VerifyAccountRequest $request) {
    //     try {
    //         DB::beginTransaction();

    //         $validated = $request->validated();

    //         $user = $request->user;

    //         $otp = $user->getVerifyAcountOTP();
            
    //         if($user->email_verified_at) {
    //             return Helpers::throwConflictError('User already verified');
    //         }    

    //         if(!$otp) {
    //             return Helpers::throwNotFoundError('OTP not found or expired, please request again');
    //         }

    //         if(!Hash::check($validated['otp'], $otp->token)) {
    //             return Helpers::throwUnauthorizedError('Invalid OTP');
    //         }

    //         $user->email_verified_at = now();
    //         $user->save();

    //         OneTimePassword::where('email', $user->email)->delete();

    //         DB::commit();

    //         return Helpers::returnOkResponse('User verified', $user);
    //     } catch (\Throwable $th) {
    //         DB::rollBack();
    //         return Helpers::throwInternalError($th);
    //     }
    // }

    // public function resetPassword(ResetPasswordRequest $request) {
    //     try{
    //         DB::beginTransaction();

    //         $validated = $request->validated();

    //         $user = User::where('email', $validated['email'])->first();

    //         $otp = $user->getResetPasswordOTP();

    //         if(!$otp) {
    //             return Helpers::throwConflictError('OTP expired, please request again');
    //         }    

    //         if(!Hash::check($validated['otp'], $otp->token)) {
    //             return Helpers::throwUnauthorizedError('Invalid OTP');
    //         }

    //         $user->password = Hash::make($validated['password']);
    //         $user->save();
            
    //         OneTimePassword::where('email', $user->email)->delete();

    //         DB::commit();

    //         return Helpers::returnOkResponse('Password reset successfuly', $user);
    //     } catch (\Throwable $th) {
    //         DB::rollBack();
    //         return Helpers::throwInternalError($th);
    //     }
    // }
}