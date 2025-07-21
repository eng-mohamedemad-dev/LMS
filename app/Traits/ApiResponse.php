<?php

namespace App\Traits;

trait ApiResponse
{
    static function success($message,$data = null,$code=200) {
          return response()->json([
            'status' => true,
            'message' => $message,
            'data' => $data
        ], $code);
    }

    static function error($message,$data = null,$code=422) {
          return response()->json([
            'status' => false,
            'message' => $message,
            'data' => $data
        ], $code);
    }
}
