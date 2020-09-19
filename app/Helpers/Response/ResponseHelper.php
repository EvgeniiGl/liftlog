<?php

namespace App\Helpers\Response;


class ResponseHelper implements ResponseInterface
{
    static private $status;
    static private $message;
    static private $code;
    static private $data;

    static public function getStatus()
    {
        return self::$status;
    }

    static public function getMessage()
    {
        return self::$message;
    }

    public static function getData()
    {
        return self::$data;
    }

    public static function setStatus(bool $status)
    {
        self::$status = $status;
    }

    public static function setMessage(string $message)
    {
        self::$message = $message;
    }

    public static function setData($data)
    {
        self::$data = $data;
    }

    public static function getCode()
    {
        return self::$code;
    }

    public static function setCode(int $code)
    {
        self::$code = $code;
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    static function successResponse()
    {
        $data = [
            "status"  => self::$status ?? true,
            "code"    => self::$code ?? 200,
            "message" => self::$message ?? "OK",
            "data"    => self::$data ?? null
        ];
        return response()->json($data, $data['code']);
    }

    /**
     * @return string json
     */
    static function successStrJson()
    {
        $data = [
            "status"  => self::$status ?? true,
            "code"    => self::$code ?? 200,
            "message" => self::$message ?? "OK",
            "data"    => self::$data ?? null
        ];
        return json_encode($data);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public static function errorResponse()
    {
        $data = [
            "status"  => self::$status ?? false,
            "code"    => self::$code ?? 404,
            "message" => self::$message ?? "Ошибка сервера",
            "data"    => self::$data ?? null
        ];

        return response()->json($data, $data['code']);
    }

}
