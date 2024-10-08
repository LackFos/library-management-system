<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Http\Requests\OneTimePassword\OneTimePasswordVerifyRequest;
use App\Models\OneTimePassword;
use Illuminate\Support\Facades\Hash;

class OneTimePasswordController extends Controller
{
    public function verify(OneTimePasswordVerifyRequest $request)
    {
        try {
            $validated = $request->validated();

            $otp = OneTimePassword::where(['email' => $validated['email'], 'name' => $validated['name']])->first();

            if(!$otp || !Hash::check($validated['otp'], $otp->token)) {
                return ResponseHelper::throwUnauthorizedError('Invalid OTP');
            }
        
            return ResponseHelper::returnOkResponse('OTP Valid');
        } catch (\Throwable $th) {
            return ResponseHelper::throwInternalError($th);
        }
    }
}