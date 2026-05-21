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

// Session
define('SESSION_LIFETIME', 3600); // 1 hour
