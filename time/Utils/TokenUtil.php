<?php
class TokenUtil
{
    public static $secret_key = "schuanhe";
    // 生成令牌
    public static function generateToken($data, $expiration = 3600 * 24 * 3): string
    {

        $currentTime = time();

        $header = json_encode(['typ' => 'JWT', 'alg' => 'HS256']);
        $payload = json_encode(['data' => $data, 'exp' => $currentTime + $expiration]);

        $base64UrlHeader = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($header));
        $base64UrlPayload = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($payload));

        $signature = hash_hmac('sha256', $base64UrlHeader . "." . $base64UrlPayload, self::$secret_key, true);
        $base64UrlSignature = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($signature));

        return $base64UrlHeader . "." . $base64UrlPayload . "." . $base64UrlSignature;
    }
    // 验证令牌
    public static function verifyToken($token): array
    {
        list($base64UrlHeader, $base64UrlPayload, $base64UrlSignature) = explode('.', $token);

        $payload = json_decode(base64_decode(str_replace(['-', '_'], ['+', '/'], $base64UrlPayload)), true);

        $signature = base64_decode(str_replace(['-', '_'], ['+', '/'], $base64UrlSignature));
        $expectedSignature = hash_hmac('sha256', $base64UrlHeader . "." . $base64UrlPayload, self::$secret_key, true);

        // 验证签名是否匹配
        if (hash_equals($expectedSignature, $signature)) {
            // 验证令牌是否过期
            if (isset($payload['exp']) && $payload['exp'] >= time()) {
                return array('code' => true, 'msg' => '验证成功', 'data' => $payload);
            } else {
                // 令牌已过期
                return array('code' => false, 'msg' => '令牌已过期');
            }
        } else {
            return array('code' => false, 'msg' => '签名不匹配');
        }
    }

    // 在cookie中验证并拿出token
    public static function checkToken(): array
    {
        $token = $_COOKIE['token'];
        return self::verifyToken($token);
    }
}