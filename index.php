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
    
    // Check src/ first, then config/ for App\Config namespace
    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';
    if (file_exists($file)) {
        require $file;
        return;
    }
    
    // Fallback: check config/ directory
    $config_file = __DIR__ . '/config/' . str_replace('\\', '/', $relative_class) . '.php';
    if (file_exists($config_file)) {
        require $config_file;
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
$router->get('/post/{id}', 'PageController@showPost');
$router->get('/login', 'AuthController@showLogin');
$router->post('/login', 'AuthController@login');
$router->get('/register', 'AuthController@showRegister');
$router->get('/register/player', 'AuthController@showPlayerRegister');
$router->post('/register/player', 'AuthController@registerPlayer');
$router->get('/register/coach', 'AuthController@showCoachRegister');
$router->post('/register/coach', 'AuthController@registerCoach');
$router->post('/logout', 'AuthController@logout');

// Player routes (auth required)
$router->get('/player/profile', 'PlayerController@showProfile', ['AuthMiddleware']);
$router->get('/player/profile/edit', 'PlayerController@editProfile', ['AuthMiddleware']);
$router->post('/player/profile/edit', 'PlayerController@updateProfile', ['AuthMiddleware']);
$router->get('/player/status', 'PlayerController@showStatus', ['AuthMiddleware']);
$router->get('/player/announcements', 'PlayerController@announcements', ['AuthMiddleware']);
$router->post('/player/documents/upload', 'DocumentController@upload', ['AuthMiddleware']);

// Coach routes (auth required)
$router->get('/coach/profile', 'CoachController@showProfile', ['AuthMiddleware', 'RoleMiddleware:coach']);
$router->get('/coach/edit', 'CoachController@editProfile', ['AuthMiddleware', 'RoleMiddleware:coach']);
$router->post('/coach/edit', 'CoachController@updateProfile', ['AuthMiddleware', 'RoleMiddleware:coach']);
$router->get('/coach/team', 'CoachController@showTeam', ['AuthMiddleware', 'RoleMiddleware:coach']);
$router->get('/coach/player/{id}', 'CoachController@showPlayer', ['AuthMiddleware', 'RoleMiddleware:coach']);
$router->get('/coach/announcements', 'CoachController@announcements', ['AuthMiddleware', 'RoleMiddleware:coach']);

// Admin routes (admin only)
$router->get('/admin', 'AdminController@dashboard', ['AuthMiddleware', 'RoleMiddleware:admin']);
$router->get('/admin/profile', 'AdminController@profile', ['AuthMiddleware', 'RoleMiddleware:admin']);
$router->post('/admin/profile/update', 'AdminController@updateProfile', ['AuthMiddleware', 'RoleMiddleware:admin']);
$router->post('/admin/profile/password', 'AdminController@changePassword', ['AuthMiddleware', 'RoleMiddleware:admin']);
$router->get('/admin/admins/create', 'AdminController@createAdminForm', ['AuthMiddleware', 'RoleMiddleware:admin']);
$router->post('/admin/admins/create', 'AdminController@createAdmin', ['AuthMiddleware', 'RoleMiddleware:admin']);
$router->get('/admin/players', 'AdminController@players', ['AuthMiddleware', 'RoleMiddleware:admin']);
$router->get('/admin/players/create', 'AdminController@createPlayerForm', ['AuthMiddleware', 'RoleMiddleware:admin']);
$router->post('/admin/players/create', 'AdminController@createPlayer', ['AuthMiddleware', 'RoleMiddleware:admin']);
$router->get('/admin/players/{id}', 'AdminController@playerDetail', ['AuthMiddleware', 'RoleMiddleware:admin']);
$router->post('/admin/players/{id}/status', 'AdminController@updatePlayerStatus', ['AuthMiddleware', 'RoleMiddleware:admin']);
$router->get('/admin/coaches', 'AdminController@coaches', ['AuthMiddleware', 'RoleMiddleware:admin']);
$router->get('/admin/coaches/create', 'AdminController@createCoachForm', ['AuthMiddleware', 'RoleMiddleware:admin']);
$router->post('/admin/coaches/create', 'AdminController@createCoach', ['AuthMiddleware', 'RoleMiddleware:admin']);
$router->get('/admin/coaches/{id}', 'AdminController@coachDetail', ['AuthMiddleware', 'RoleMiddleware:admin']);
$router->post('/admin/coaches/{id}/status', 'AdminController@updateCoachStatus', ['AuthMiddleware', 'RoleMiddleware:admin']);
$router->get('/admin/teams', 'AdminController@teams', ['AuthMiddleware', 'RoleMiddleware:admin']);
$router->get('/admin/teams/create', 'AdminController@createTeamForm', ['AuthMiddleware', 'RoleMiddleware:admin']);
$router->post('/admin/teams/create', 'AdminController@createTeam', ['AuthMiddleware', 'RoleMiddleware:admin']);
$router->get('/admin/teams/{id}', 'AdminController@teamDetail', ['AuthMiddleware', 'RoleMiddleware:admin']);
$router->get('/admin/documents', 'AdminController@documents', ['AuthMiddleware', 'RoleMiddleware:admin']);
$router->post('/admin/documents/{id}/verify', 'AdminController@verifyDocument', ['AuthMiddleware', 'RoleMiddleware:admin']);
$router->post('/admin/notifications/send', 'AdminController@sendNotification', ['AuthMiddleware', 'RoleMiddleware:admin']);
$router->get('/admin/announcements', 'AdminController@announcements', ['AuthMiddleware', 'RoleMiddleware:admin']);
$router->get('/admin/announcements/create', 'AdminController@createAnnouncementForm', ['AuthMiddleware', 'RoleMiddleware:admin']);
$router->post('/admin/announcements/create', 'AdminController@createAnnouncement', ['AuthMiddleware', 'RoleMiddleware:admin']);
$router->get('/admin/posts', 'AdminController@posts', ['AuthMiddleware', 'RoleMiddleware:admin']);
$router->get('/admin/posts/create', 'AdminController@createPostForm', ['AuthMiddleware', 'RoleMiddleware:admin']);
$router->post('/admin/posts/create', 'AdminController@createPost', ['AuthMiddleware', 'RoleMiddleware:admin']);
$router->get('/admin/posts/edit/{id}', 'AdminController@editPostForm', ['AuthMiddleware', 'RoleMiddleware:admin']);
$router->post('/admin/posts/edit/{id}', 'AdminController@updatePost', ['AuthMiddleware', 'RoleMiddleware:admin']);
$router->post('/admin/posts/delete/{id}', 'AdminController@deletePost', ['AuthMiddleware', 'RoleMiddleware:admin']);
$router->post('/admin/posts/toggle/{id}', 'AdminController@togglePost', ['AuthMiddleware', 'RoleMiddleware:admin']);

// Dispatch the router
$router->dispatch();
