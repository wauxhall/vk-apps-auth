<?php

namespace Wauxhall\VkAppsAuth\Traits;

use Illuminate\Http\JsonResponse;

trait SendResponse
{
    /**
     * Success response method.
     *
     * @param $data
     * @return JsonResponse
     */
    public function sendResponse($data) : JsonResponse
    {
        return response()->json([
            'success' => true,
            'data'    => $data
        ], 200);
    }

    /**
     * Return error response.
     *
     * @param string $error
     * @param int $code
     * @return JsonResponse
     */
    public function sendError(string $error, int $code = 422) : JsonResponse
    {
        return response()->json([
            'success' => false,
            'error' => [
                'message' => $error,
                'code'    => $code
            ]
        ], $code);
    }
}
