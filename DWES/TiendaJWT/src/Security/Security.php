<?php
namespace Security;

use Exception;

class Security
{
    public function __construct()
    {
    }
    final public static function secretKey(): string
    {
        return $_ENV['SECRET_KEY'];

    }
    public function encryptPassword(string $password): string
    {
        return password_hash($password, PASSWORD_BCRYPT, ['cost' => 5]);
    }

    public function validatePassword(string $inputPassword, string $databasePassword): bool
    {
        return password_verify($inputPassword, $databasePassword);
    }

    final public static function createToken(string $key, array $data): string
    {
        $time = time();
        $token = array(
            "iat" => $time,
            "exp" => $time + 3600,
            "data" => $data
        );

        return self::encode($token, $key, 'HS256');
    }

    private static function encode(array $payload, string $key, string $alg = 'HS256'): string
    {
        // cabecera
        $header = json_encode(['typ' => 'JWT', 'alg' => $alg]);
        $base64Header = self::base64UrlEncode($header);

        // carga (payload)
        $base64Payload = self::base64UrlEncode(json_encode($payload));

        // firma
        $signature = hash_hmac('sha256', "$base64Header.$base64Payload", $key, true);
        $base64Signature = self::base64UrlEncode($signature);

        return "$base64Header.$base64Payload.$base64Signature";
    }

    public static function decode(string $jwt, string $key): array
    {
        $parts = explode('.', $jwt);
        if (count($parts) !== 3) {
            throw new Exception('Invalid token format.');
        }

        [$base64Header, $base64Payload, $base64Signature] = $parts;

        $header = json_decode(self::base64UrlDecode($base64Header), true);
        $payload = json_decode(self::base64UrlDecode($base64Payload), true);

        $signature = self::base64UrlDecode($base64Signature);
        $validSignature = hash_hmac('sha256', "$base64Header.$base64Payload", $key, true);

        if (!hash_equals($validSignature, $signature)) {
            throw new Exception('Invalid token signature.');
        }

        if (isset($payload['exp']) && time() > $payload['exp']) {
            throw new Exception('Token has expired.');
        }

        return $payload;
    }

    private static function base64UrlEncode(string $data): string
    {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }

    private static function base64UrlDecode(string $data): string
    {
        return base64_decode(strtr($data, '-_', '+/'));
    }

    public static function generateToken(): string
    {
        $userData = [
            'email' => $_SESSION['identity']['email'],
            'name' => $_SESSION['identity']['nombre']
        ];

        $key = self::secretKey();

        return self::createToken($key, $userData);
    }

}
