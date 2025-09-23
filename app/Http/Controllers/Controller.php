<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
    protected $baseUrl;

    public function __construct()
    {
        $this->baseUrl = config('services.docunumber.base_url');
    }
    protected function errorResponse($message, $details = null, $code = 500)
    {
        return response()->json([
            'status' => 'error',
            'message' => $message,
            'details' => $details,
            'code' => $code,
            'timestamp' => now()->toDateTimeString(),
        ], $code);
    }
    protected function successResponse($message, $data = null, $code = 200)
    {
        return response()->json([
            'status' => 'success',
            'message' => $message,
            'data' => $data,
            'code' => $code,
            'timestamp' => now()->toDateTimeString(),
        ], $code);
    }
}
