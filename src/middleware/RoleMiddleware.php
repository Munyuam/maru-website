<?php
declare(strict_types=1);

namespace App\Middleware;

use App\Helpers\Session;

/**
 * Class RoleMiddleware
 * Middleware to ensure the authenticated user has the necessary role(s).
 */
class RoleMiddleware
{
    /**
     * Handle the role authorization request.
     *
     * @param string|array $roles The required role or array of allowed roles.
     * @return void
     */
    public static function handle(string|array $roles): void
    {
        // First ensure the user is authenticated
        AuthMiddleware::handle();

        $allowedRoles = is_array($roles) ? $roles : [$roles];
        $userRole = Session::getUserRole();

        // Check if the user's role is in the list of allowed roles
        if (!in_array($userRole, $allowedRoles, true)) {
            Session::setFlash('error', 'Unauthorized access');
            
            // Redirect based on actual role
            switch ($userRole) {
                case 'admin':
                    header('Location: /admin');
                    break;
                case 'player':
                    header('Location: /player/profile');
                    break;
                case 'coach':
                    header('Location: /coach/team');
                    break;
                default:
                    header('Location: /');
                    break;
            }
            
            exit;
        }
    }
}
