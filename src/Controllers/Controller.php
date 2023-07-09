<?php

namespace Pableiros\BaseFoundationLaravel\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function performJsonResponse($jsonResponse)
    {
        return response()->json($jsonResponse, 200);
    }

    public function performSuccessResponse($extraData = [])
    {
        $response = $extraData;
        $response['message'] = 'success';

        return $this->performJsonResponse($response);
    }

    public function performUnauthorizedResponse($message)
    {
        return response()->json(['message' => $message], 401);
    }

    public function createErrorValidationResponse($errorArray)
    {
        $error = [
            'message' => 'The given data was invalid.',
            'errors' => $errorArray
        ];

        return response()->json($error, 422);
    }
}
