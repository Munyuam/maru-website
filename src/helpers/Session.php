<?php

namespace App\Helpers;

class Session {
    public static function start(): void {
        if (session_status() === PHP_SESSION_NONE) {
            $lifetime = defined('SESSION_LIFETIME') ? SESSION_LIFETIME : 86400;
            ini_set('session.gc_maxlifetime', (string)$lifetime);
            session_set_cookie_params([
                'lifetime' => $lifetime,
                'path' => '/',
                'domain' => '',
                'secure' => isset($_SERVER['HTTPS']),
                'httponly' => true,
                'samesite' => 'Lax'
            ]);
            session_start();
        }
    }

    public static function set(string $key, mixed $value): void {
        $_SESSION[$key] = $value;
    }

    public static function get(string $key, mixed $default = null): mixed {
        return $_SESSION[$key] ?? $default;
    }

    public static function has(string $key): bool {
        return isset($_SESSION[$key]);
    }

    public static function remove(string $key): void {
        unset($_SESSION[$key]);
    }

    public static function flash(string $key, mixed $value): void {
        $_SESSION['flash'][$key] = $value;
    }

    public static function setFlash(string $key, mixed $value): void {
        self::flash($key, $value);
    }

    public static function getFlash(string $key): mixed {
        if (isset($_SESSION['flash'][$key])) {
            $value = $_SESSION['flash'][$key];
            unset($_SESSION['flash'][$key]);
            return $value;
        }
        return null;
    }

    public static function generateCsrfToken(): string {
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }

    public static function validateCsrfToken(string $token): bool {
        return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
    }

    public static function setUser(array $user): void {
        self::set('user', $user);
    }

    public static function getUser(): ?array {
        return self::get('user');
    }

    public static function isLoggedIn(): bool {
        return self::has('user');
    }

    public static function getUserRole(): ?string {
        $user = self::getUser();
        return $user['role'] ?? null;
    }

    public static function getUserId(): ?int {
        $user = self::getUser();
        return isset($user['id']) ? (int)$user['id'] : null;
    }

    public static function destroy(): void {
        session_unset();
        session_destroy();
        session_start();
        session_regenerate_id(true);
    }
}
