<?php
namespace App\Helpers;
use App\Utils\Models\BaseResponseModel;
use App\Utils\Models\ErrorResponseModel;
use Exception;
class ResponseHelper{
    public static function GetSuccesResponse($data = null, $responseCode, $view =  null)
    {
        $response = new BaseResponseModel;
        $response->data = $data;
        if($view){
            return view($view, ['response' => $response->data]);
        }
        return response()->json($response, $responseCode);
    }
    public static function GetErrorResponse($message, $exception, $responseCode, $errors = [], $withView = false)
    {
        $response = new ErrorResponseModel;
        $response->message = $message;
        $response->exceptionMessage = $exception ? $exception->getMessage(): NULL;
        $response->errors = $errors;
        if($withView){
            return response(view('errors.404'), 404);
        }
        return response()->json($response, $responseCode);
    }
    public static function GetErrorFromRequest($message, $errors = [], $responseCode)
    {
        $response = new ErrorResponseModel;
        $response->message = $message;
        $response->errors = $errors;
        $response->exceptionMessage = "Complete the required fields";
        return response()->json($response, $responseCode);
    }
    public static function ParseResponseToJson($response)
    {
        $content = $response->getContent();
        $data = json_decode($content);
        if (is_null($data) && json_last_error() !== JSON_ERROR_NONE) {
            throw new Exception("JSON decode error");
        }
        return $data;
    }
    public static function GetSuccesResponseXML($data = null, $responseCode, $view)
    {
        $response = new BaseResponseModel;
        $response->data = $data;
        return response()->view($view, ['response' => $response->data])->header('Content-Type', 'text/xml');
    }
}
