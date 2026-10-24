<?php
/**
 * Bearer-token authentication for the JSON API.
 */
class ApiAuth
{
    public static function requireUser(): array
    {
        $token = self::bearerToken();
        if ($token === null) {
            self::fail(401, 'Token API tidak ditemukan. Kirim header: Authorization: Bearer <token>.');
        }

        $tokenModel = new ApiToken();
        $user = $tokenModel->findUserByToken($token);
        if (!$user) {
            self::fail(401, 'Token API tidak valid atau sudah dicabut.');
        }

        $tokenModel->touch((int) $user['token_id']);
        unset($user['token_id']);
        return $user;
    }

    private static function bearerToken(): ?string
    {
        $header = (string) ($_SERVER['HTTP_AUTHORIZATION'] ?? '');
        if ($header === '' && function_exists('getallheaders')) {
            foreach (getallheaders() as $name => $value) {
                if (strtolower((string) $name) === 'authorization') {
                    $header = (string) $value;
                    break;
                }
            }
        }
        if (preg_match('/^Bearer\s+(.+)$/i', trim($header), $matches)) {
            return trim($matches[1]);
        }
        return null;
    }

    public static function fail(int $status, string $message): void
    {
        http_response_code($status);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode([
            'success' => false,
            'message' => $message,
        ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        exit;
    }
}
