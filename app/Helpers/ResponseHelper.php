<?php

namespace App\Helpers;

use App\Enums\StatusCode;
use Illuminate\Support\Facades\Log;

Class ResponseHelper {    
    public static function returnOkResponse($message, $data = null) 
    {
        return response()->json(['success' => 'true', 'message' => $message, 'payload' => $data], StatusCode::OK);
    }

    public static function returnCreatedResponse($message, $data) 
    {
        return response()->json(['success' => 'true', 'message' => $message, 'payload' => $data], StatusCode::CREATED);
    } 

    public static function throwUnauthorizedError($message) {
        return response()->json(['success' => 'false', 'message' => $message], StatusCode::UNAUTHORIZED);
    }

    public static function throwTooManyRequest($message) {
        return response()->json(['success' => 'false', 'message' => $message], StatusCode::TOO_MANY_REQUEST);
    }

    public static function throwNotFoundError($message)
    {
        return response()->json(['success' => 'false', 'message' => $message], StatusCode::NOT_FOUND);
    }

    public static function throwConflictError($message)
    {
        return response()->json(['success' => 'false', 'message' => $message], StatusCode::CONFLICT);
    }

    public static function throwInternalError($errors) {
        Log::debug($errors);
        return response()->json(['success' => 'false', 'message' => 'An unexpected error occurred on the server.', 'payload' => $errors], StatusCode::INTERNAL_SERVER_ERROR);
    }
}