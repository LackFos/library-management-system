<?php

namespace App\Helpers;

use App\Enums\StatusCode;

Class ResponseHelper {    
    public static function returnOkResponse($message, $data) 
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

    public static function throwNotFoundError($message)
    {
        return response()->json(['success' => 'false', 'message' => $message], StatusCode::NOT_FOUND);
    }

    public static function throwConflictError($message)
    {
        return response()->json(['success' => 'false', 'message' => $message], StatusCode::CONFLICT);
    }

    public static function throwInternalError($errors) {
        return response()->json(['success' => 'false', 'message' => 'An unexpected error occurred on the server.', 'payload' => $errors], StatusCode::INTERNAL_SERVER_ERROR);
    }
}