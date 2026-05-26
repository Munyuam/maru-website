<?php
declare(strict_types=1);

namespace App\Middleware;

use App\Helpers\Session;

/**
 * Class AuthMiddleware
 * Middleware to ensure the user is logged in before accessing certain routes.
 */
class AuthMiddleware
{
    /**
     * Handle the authorization request.
     * Checks if the user is logged in. If not, sets a flash message and redirects to login.
     *
     * @return void
     */
    public static function handle(): void
    {
        if (!Session::isLoggedIn()) {
            Session::flash('error', 'Please log in to continue');
            header('Location: ' . url('/login'));
            exit;
        }
    }
}
