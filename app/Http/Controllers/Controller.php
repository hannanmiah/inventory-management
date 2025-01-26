<?php

namespace App\Http\Controllers;

abstract class Controller
{
    public function success(mixed $data = [], string $message = 'Success', int $code = 200)
    {
        return response()->json([
            'data' => $data,
            'code' => $code,
            'message' => $message,
        ], $code);
    }

    public function error(string $message, int $code = 400)
    {
        return response()->json([
            'code' => $code,
            'message' => $message,
        ], $code);
    }
}
