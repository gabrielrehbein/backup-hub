<?php

namespace App\Shared\Http\Responses;

use Illuminate\Http\JsonResponse as HttpJsonResponse;

class JSONResponse
{
    public static function success($data = null, string $message = 'Success', int $statusCode = 200): HttpJsonResponse
    {
        return response()->json([
            'message' => $message,
            'data' => $data,
        ], $statusCode);
    }

    public static function error(string $message = 'Error', int $statusCode = 400, $data = null): HttpJsonResponse
    {
        return response()->json([
            'message' => $message,
            'data' => $data,
        ], $statusCode);
    }
}
