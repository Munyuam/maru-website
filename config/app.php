<?php

// Application Constants
define('APP_NAME', 'MARU Player Registration');
define('APP_URL', 'http://localhost:8000');
define('APP_ROOT', dirname(__DIR__));

// Database Configuration
define('DB_HOST', 'localhost');
define('DB_NAME', 'maru_db');
define('DB_USER', 'root');
define('DB_PASS', '');

// File Upload Settings
define('UPLOAD_DIR', APP_ROOT . '/public/uploads');
define('MAX_FILE_SIZE', 5 * 1024 * 1024); // 5MB
define('ALLOWED_FILE_TYPES', ['jpg', 'jpeg', 'png', 'pdf']);

// Pagination
define('ITEMS_PER_PAGE', 15);

// Session (24 hours)
define('SESSION_LIFETIME', 86400);

/**
 * Helper to generate absolute URLs relative to the application root.
 * Works both at the root of a domain and when deployed in a subdirectory.
 */
if (!function_exists('url')) {
    function url(string $path = ''): string {
        static $basePath = null;
        if ($basePath === null) {
            $scriptName = $_SERVER['SCRIPT_NAME'] ?? '';
            $dir = dirname($scriptName);
            $basePath = ($dir === DIRECTORY_SEPARATOR || $dir === '.') ? '' : str_replace('\\', '/', $dir);
        }
        return $basePath . '/' . ltrim($path, '/');
    }
}

/**
 * Helper to perform redirects relative to the application base.
 */
if (!function_exists('redirect')) {
    function redirect(string $path): void {
        header('Location: ' . url($path));
        exit;
    }
}

