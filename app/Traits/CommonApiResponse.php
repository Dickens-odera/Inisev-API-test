<?php


namespace App\Traits;
use Illuminate\Http\JsonResponse;

trait CommonApiResponse
{
    public function commonApiResponse(bool $status, $message, $data, $code): JsonResponse
    {
        return response()->json(['success' => $status, 'message' =>  $message, 'data'  => $data], $code);
    }
}
