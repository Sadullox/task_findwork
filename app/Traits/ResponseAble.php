<?php

namespace App\Traits;

use Illuminate\Http\Exceptions\HttpResponseException;

trait ResponseAble
{

    /**
     * @param array $data
     * @param string $message
     * @param int $code
     * @return \Illuminate\Http\JsonResponse
     * Send is success handled
     */
    
    protected function sendResponse($data = [], $message = 'Success', $code = 200) 
    {
        return response()->json([
                'success' => true,
                'code'    => $code,
                'result'    => $data,
                'message' => $message
        ])->setStatusCode($code);
    }

    /**
     * @param array $data
     * @param string $message
     * @param int $code
     * @return \Illuminate\Http\JsonResponse
     * Send is success handled
     */
    
    protected function sendResponseList($data = [], $message = 'Success', $code = 200)
    {
        return response()->json([
                'success' => true,
                'code'    => $code,
                'result'    => new \App\Http\Resources\ResponseListCollection($data),
                'message' => $message
        ])->setStatusCode($code);
    }


    /**
     * @param array $data
     * @param string $message
     * @param int $code
     * @return \Illuminate\Http\JsonResponse
     * Send if error handled
     */
    protected function sendError($data = [], $message = 'Error', $code = 404)
    {
        throw new HttpResponseException(
            response()->json([
                    'success' => false,
                    'code'    => $code,
                    'error'   => $data,
                    'message' => $message
            ])->setStatusCode($code)
        );
    }
}
