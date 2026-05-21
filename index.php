<?php

// Autoloader
spl_autoload_register(function ($class) {
    // Convert namespace to full file path
    $prefix = 'App\\';
    $base_dir = __DIR__ . '/src/';

    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }

    $relative_class = substr($class, $len);
    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';

    if (file_exists($file)) {
        require $file;
    }
});

// Require config files
require_once __DIR__ . '/config/app.php';
require_once __DIR__ . '/config/database.php';

use App\Helpers\Session;
use App\Helpers\Router;

// Start session
Session::start();

// Initialize router
$router = new Router();

// Public routes
$router->get('/', 'PageController@welcome');
$router->get('/login', 'AuthController@showLogin');
$router->post('/login', 'AuthController@login');
$router->get('/register', 'AuthController@showRegister');
$router->get('/register/player', 'AuthController@showPlayerRegister');
$router->post('/register/player', 'AuthController@registerPlayer');
$router->get('/register/coach', 'AuthController@showCoachRegister');
$router->post('/register/coach', 'AuthController@registerCoach');
$router->post('/logout', 'AuthController@logout');

// Player routes (auth required)
$router->get('/player/profile', 'PlayerController@showProfile');
$router->get('/player/profile/edit', 'PlayerController@editProfile');
$router->post('/player/profile/edit', 'PlayerController@updateProfile');
$router->get('/player/status', 'PlayerController@showStatus');
$router->post('/player/documents/upload', 'DocumentController@upload');

// Coach routes (auth required)
$router->get('/coach/profile', 'CoachController@showProfile');
$router->get('/coach/team', 'CoachController@showTeam');

// Admin routes (admin only)
$router->get('/admin', 'AdminController@dashboard');
$router->get('/admin/players', 'AdminController@players');
$router->get('/admin/players/{id}', 'AdminController@playerDetail');
$router->post('/admin/players/{id}/status', 'AdminController@updatePlayerStatus');
$router->get('/admin/coaches', 'AdminController@coaches');
$router->get('/admin/coaches/{id}', 'AdminController@coachDetail');
$router->get('/admin/teams', 'AdminController@teams');
$router->get('/admin/teams/create', 'AdminController@createTeamForm');
$router->post('/admin/teams/create', 'AdminController@createTeam');
$router->get('/admin/teams/{id}', 'AdminController@teamDetail');
$router->get('/admin/documents', 'AdminController@documents');
$router->post('/admin/documents/{id}/verify', 'AdminController@verifyDocument');
$router->post('/admin/notifications/send', 'AdminController@sendNotification');

// Dispatch the router
$router->dispatch();
