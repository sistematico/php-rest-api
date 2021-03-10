<?php

namespace App\Core;

class Response
{
    private static $response = [];

    public static function setResponse(bool $success, int $httpStatusCode, string $message, array $data = [], bool $cache = false)
    {
        self::$response["success"] = $success;
        self::$response["httpStatusCode"] = $httpStatusCode;
        self::$response["message"] = $message;
        self::$response["cache"] = $cache;
        self::$response["data"] = $data;
    }

    public static function send()
    {
        header('Content-type:application/json;charset=utf-8');

        if (self::$response['cache'] === true) {
            header('Cache-Control: max-age=60');
        } else {
            header('Cache-Control: no-cache, no-store');
        }

        if (!is_numeric(self::$response['httpStatusCode']) || (self::$response['success'] !== false && self::$response['success'] !== true)) {
            http_response_code(500);
            $data['httpStatusCode'] = 500;
            $data['success'] = false;
            $data['messages'] = "Response creation error";
        } else {
            http_response_code(self::$response['httpStatusCode']);
            $data['httpStatusCode'] = self::$response['httpStatusCode'];
            $data['success'] = self::$response['success'];
            $data['messages'] = self::$response['message'];
            $data['data'] = self::$response['data'];
        }
        echo json_encode($data);
    }
}