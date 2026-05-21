<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Helpers\Session;
use App\Helpers\Validator;
use App\Models\Player;
use App\Models\User;

class PlayerController
{
    /**
     * Ensure the user is logged in as a player.
     * Returns the player profile or redirects.
     */
    private function requirePlayerProfile(): ?array
    {
        if (!Session::isLoggedIn() || Session::getUserRole() !== 'player') {
            header('Location: /login');
            exit;
        }

        $userId = Session::getUserId();
        $player = Player::findByUserId($userId);

        if (!$player) {
            Session::flash('error', 'Player profile not found.');
            header('Location: /login');
            exit;
        }

        return $player;
    }

    /**
     * Show player profile page
     */
    public function showProfile(): void
    {
        $player = $this->requirePlayerProfile();
        $pageTitle = 'My Profile - MARU';

        ob_start();
        require __DIR__ . '/../../views/pages/player-profile.php';
        $content = ob_get_clean();

        require __DIR__ . '/../../views/layouts/main.php';
    }

    /**
     * Show edit profile form
     */
    public function editProfile(): void
    {
        $player = $this->requirePlayerProfile();
        $pageTitle = 'Edit Profile - MARU';

        ob_start();
        require __DIR__ . '/../../views/pages/player-edit.php';
        $content = ob_get_clean();

        require __DIR__ . '/../../views/layouts/main.php';
    }

    /**
     * Handle profile update
     */
    public function updateProfile(): void
    {
        $player = $this->requirePlayerProfile();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /player/profile/edit');
            exit;
        }

        $csrf = $_POST['csrf_token'] ?? '';
        if (!Session::validateCsrfToken($csrf)) {
            Session::flash('error', 'Invalid security token.');
            header('Location: /player/profile/edit');
            exit;
        }

        $validator = new Validator($_POST);
        $validator->validate([
            'phone' => 'required',
            'position' => 'required',
            'nationality' => 'required'
        ]);

        if ($validator->hasErrors()) {
            Session::flash('errors', $validator->errors());
            Session::flash('old', $_POST);
            header('Location: /player/profile/edit');
            exit;
        }

        $data = $validator->validated();
        
        $success = Player::update((int)$player['id'], [
            'phone' => $data['phone'],
            'position' => $data['position'],
            'nationality' => $data['nationality']
        ]);

        if ($success) {
            Session::flash('success', 'Profile updated successfully.');
            header('Location: /player/profile');
            exit;
        } else {
            Session::flash('error', 'Failed to update profile.');
            header('Location: /player/profile/edit');
            exit;
        }
    }

    /**
     * Show player registration status
     */
    public function showStatus(): void
    {
        $player = $this->requirePlayerProfile();
        $status = Player::getRegistrationStatus((int)$player['id']);
        $pageTitle = 'Registration Status - MARU';

        ob_start();
        require __DIR__ . '/../../views/pages/player-status.php';
        $content = ob_get_clean();

        require __DIR__ . '/../../views/layouts/main.php';
    }
}
