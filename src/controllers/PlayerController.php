<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Config\Database;
use App\Helpers\FileUpload;
use App\Helpers\Session;
use App\Helpers\Validator;
use App\Models\Document;
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
            header('Location: ' . url('/login'));
            exit;
        }

        $userId = Session::getUserId();
        $player = Player::findByUserId($userId);

        if (!$player) {
            Session::flash('error', 'Player profile not found.');
            header('Location: ' . url('/login'));
            exit;
        }

        return $player;
    }

    /**
     * Show player profile page
     */
    public function showProfile(): void
    {
        if (!Session::isLoggedIn() || Session::getUserRole() !== 'player') {
            header('Location: ' . url('/login'));
            exit;
        }

        $userId = Session::getUserId();
        $player = Player::findByUserId($userId);
        $documents = Document::findByUserId($userId);
        $status = $player ? Player::getRegistrationStatus((int)$player['id']) : null;
        $db = Database::getConnection();
        $teamId = $player ? ($player['team_id'] ?? null) : null;
        $stmt = $db->prepare("
            SELECT n.*, u.first_name, u.last_name,
                   (SELECT COUNT(*) FROM notification_reads nr WHERE nr.notification_id = n.id AND nr.user_id = :uid) AS is_read_by_me
            FROM notifications n
            JOIN users u ON n.sender_id = u.id
            WHERE n.user_id = 0
              AND (n.target_type = 'all' OR (n.target_type = 'team' AND n.target_id = :tid))
            ORDER BY n.created_at DESC
            LIMIT 5
        ");
        $stmt->execute(['uid' => $userId, 'tid' => $teamId ?? 0]);
        $announcements = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        // Mark announcements as read
        foreach ($announcements as $ann) {
            if (!$ann['is_read_by_me']) {
                $stmt2 = $db->prepare("INSERT IGNORE INTO notification_reads (notification_id, user_id) VALUES (:nid, :uid)");
                $stmt2->execute(['nid' => $ann['id'], 'uid' => $userId]);
            }
        }
        $pageTitle = 'My Profile - MARU';

        ob_start();
        require __DIR__ . '/../../views/pages/player-profile.php';
        $content = ob_get_clean();

        require __DIR__ . '/../../views/layouts/player.php';
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

        require __DIR__ . '/../../views/layouts/player.php';
    }

    /**
     * Handle profile update
     */
    public function updateProfile(): void
    {
        $player = $this->requirePlayerProfile();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . url('/player/profile/edit'));
            exit;
        }

        $csrf = $_POST['csrf_token'] ?? '';
        if (!Session::validateCsrfToken($csrf)) {
            Session::flash('error', 'Invalid security token.');
            header('Location: ' . url('/player/profile/edit'));
            exit;
        }

        $validator = new Validator($_POST);
        $validator->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'nationality' => 'required',
            'date_of_birth' => 'required|date',
            'gender' => 'required|in:male,female,other',
            'position' => 'required'
        ]);

        if ($validator->hasErrors()) {
            Session::flash('errors', $validator->errors());
            Session::flash('old', $_POST);
            header('Location: ' . url('/player/profile/edit'));
            exit;
        }

        $data = $validator->validated();

        // Update user-level fields
        $userId = (int)$player['user_id'];
        $userUpdateData = [
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'phone' => $data['phone']
        ];

        // Handle avatar upload
        if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = UPLOAD_DIR . '/avatars';
            $result = FileUpload::upload($_FILES['avatar'], $uploadDir, ['jpg', 'jpeg', 'png'], MAX_FILE_SIZE);
            if ($result['success']) {
                $userUpdateData['avatar'] = $result['file_path'];
            } else {
                Session::flash('error', 'Avatar upload failed: ' . $result['error']);
                Session::flash('old', $_POST);
                header('Location: ' . url('/player/profile/edit'));
                exit;
            }
        }

        User::update($userId, $userUpdateData);

        // Update player-level fields
        $playerFields = [
            'date_of_birth' => $data['date_of_birth'],
            'gender' => $data['gender'],
            'nationality' => $data['nationality'],
            'position' => $data['position'],
            'address' => $_POST['address'] ?? null,
            'playing_experience' => $_POST['playing_experience'] ?? null,
            'previous_clubs' => $_POST['previous_clubs'] ?? null,
            'emergency_contact_name' => $_POST['emergency_contact_name'] ?? null,
            'emergency_contact_phone' => $_POST['emergency_contact_phone'] ?? null,
            'emergency_contact_relationship' => $_POST['emergency_contact_relationship'] ?? null
        ];

        Player::update((int)$player['id'], $playerFields);

        // Handle password change
        $currentPassword = $_POST['current_password'] ?? '';
        $newPassword = $_POST['new_password'] ?? '';
        $confirmPassword = $_POST['confirm_password'] ?? '';

        if (!empty($currentPassword) || !empty($newPassword) || !empty($confirmPassword)) {
            if (empty($currentPassword) || empty($newPassword) || empty($confirmPassword)) {
                Session::flash('error', 'All password fields are required to change password.');
                Session::flash('old', $_POST);
                header('Location: ' . url('/player/profile/edit'));
                exit;
            }

            if ($newPassword !== $confirmPassword) {
                Session::flash('error', 'New password and confirmation do not match.');
                Session::flash('old', $_POST);
                header('Location: ' . url('/player/profile/edit'));
                exit;
            }

            if (strlen($newPassword) < 8) {
                Session::flash('error', 'New password must be at least 8 characters.');
                Session::flash('old', $_POST);
                header('Location: ' . url('/player/profile/edit'));
                exit;
            }

            $user = User::findById($userId);
            if (!$user || !password_verify($currentPassword, $user['password'])) {
                Session::flash('error', 'Current password is incorrect.');
                Session::flash('old', $_POST);
                header('Location: ' . url('/player/profile/edit'));
                exit;
            }

            User::updatePassword($userId, $newPassword);
        }

        // Refresh session user data
        $updatedUser = User::findById($userId);
        if ($updatedUser) {
            unset($updatedUser['password']);
            Session::setUser($updatedUser);
        }

        Session::flash('success', 'Profile updated successfully.');
        header('Location: ' . url('/player/profile'));
        exit;
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

        require __DIR__ . '/../../views/layouts/player.php';
    }

    public function announcements(): void
    {
        $userId = Session::getUserId();
        $player = Player::findByUserId($userId);
        $teamId = $player ? ($player['team_id'] ?? null) : null;
        $db = Database::getConnection();
        $stmt = $db->prepare("
            SELECT n.*, u.first_name, u.last_name,
                   (SELECT COUNT(*) FROM notification_reads nr WHERE nr.notification_id = n.id AND nr.user_id = :uid) AS is_read_by_me
            FROM notifications n
            JOIN users u ON n.sender_id = u.id
            WHERE n.user_id = 0
              AND (n.target_type = 'all' OR (n.target_type = 'team' AND n.target_id = :tid))
            ORDER BY n.created_at DESC
        ");
        $stmt->execute(['uid' => $userId, 'tid' => $teamId ?? 0]);
        $announcements = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        foreach ($announcements as $ann) {
            if (!$ann['is_read_by_me']) {
                $stmt2 = $db->prepare("INSERT IGNORE INTO notification_reads (notification_id, user_id) VALUES (:nid, :uid)");
                $stmt2->execute(['nid' => $ann['id'], 'uid' => $userId]);
            }
        }

        $pageTitle = 'Announcements - MARU';
        ob_start();
        require __DIR__ . '/../../views/pages/player-announcements.php';
        $content = ob_get_clean();
        require __DIR__ . '/../../views/layouts/player.php';
    }
}
