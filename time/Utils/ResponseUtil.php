<?php
namespace Utils;
class ResponseUtil
{
    public static function success($data = null, $message = '操作成功'): array
    {
        return self::response(200, $data, $message);
    }

    public static function error($message = '错误', $data = null): array
    {
        return self::response(500, $data, $message);
    }

    public static function fail($message = '警告', $data = null): array
    {
        return self::response(400, $data, $message);
    }

    public static function notFound($message = '没有这个文件', $data = null): array
    {
        return self::response(404, $data, $message);
    }

    private static function response($success, $data, $message): array
    {
        return [
            'success' => $success,
            'data' => $data,
            'message' => $message,
        ];
    }
}