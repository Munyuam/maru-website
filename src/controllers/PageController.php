<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Helpers\Session;

class PageController
{
    /**
     * Render the landing page.
     */
    public function welcome(): void
    {
        // Redirect to dashboard if already logged in
        if (Session::isLoggedIn()) {
            $role = Session::getUserRole();
            if ($role === 'admin') {
                header('Location: /admin');
            } elseif ($role === 'coach') {
                header('Location: /coach/team');
            } else {
                header('Location: /player/profile');
            }
            exit;
        }

        $pageTitle = 'MARU - Online Player Registration System';
        ob_start();
        require __DIR__ . '/../../views/pages/welcome.php';
        $content = ob_get_clean();
        require __DIR__ . '/../../views/layouts/main.php';
    }
}
