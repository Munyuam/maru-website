<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Config\Database;
use App\Helpers\FileUpload;
use App\Helpers\Session;
use App\Helpers\Validator;
use App\Models\Coach;
use App\Models\Player;
use App\Models\Team;
use App\Models\User;

class CoachController
{
    private function getCoach(): ?array
    {
        $userId = Session::getUserId();
        if (!$userId) {
            return null;
        }
        return Coach::findByUserId($userId);
    }

    public function showProfile(): void
    {
        $coach = $this->getCoach();
        if (!$coach) {
            echo "Coach profile not found.";
            return;
        }

        $team = null;
        if ($coach['team_id']) {
            $team = Team::findById((int)$coach['team_id']);
        }

        $db = Database::getConnection();
        $teamId = $coach['team_id'] ?? null;
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
        $stmt->execute(['uid' => Session::getUserId(), 'tid' => $teamId ?? 0]);
        $announcements = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        // Mark announcements as read
        foreach ($announcements as $ann) {
            if (!$ann['is_read_by_me']) {
                $stmt2 = $db->prepare("INSERT IGNORE INTO notification_reads (notification_id, user_id) VALUES (:nid, :uid)");
                $stmt2->execute(['nid' => $ann['id'], 'uid' => Session::getUserId()]);
            }
        }

        $pageTitle = 'Coach Profile';
        ob_start();
        require __DIR__ . '/../../views/pages/coach-profile.php';
        $content = ob_get_clean();
        require __DIR__ . '/../../views/layouts/coach.php';
    }

    public function editProfile(): void
    {
        $coach = $this->getCoach();
        if (!$coach) {
            echo "Coach profile not found.";
            return;
        }

        $pageTitle = 'Edit Profile - MARU';
        ob_start();
        require __DIR__ . '/../../views/pages/coach-edit.php';
        $content = ob_get_clean();
        require __DIR__ . '/../../views/layouts/coach.php';
    }

    public function updateProfile(): void
    {
        $coach = $this->getCoach();
        if (!$coach) {
            echo "Coach profile not found.";
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . url('/coach/edit'));
            exit;
        }

        $csrf = $_POST['csrf_token'] ?? '';
        if (!Session::validateCsrfToken($csrf)) {
            Session::flash('error', 'Invalid security token.');
            header('Location: ' . url('/coach/edit'));
            exit;
        }

        $validator = new Validator($_POST);
        $validator->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email',
            'phone' => 'required'
        ]);

        if ($validator->hasErrors()) {
            Session::flash('errors', $validator->errors());
            Session::flash('old', $_POST);
            header('Location: ' . url('/coach/edit'));
            exit;
        }

        $data = $validator->validated();

        // Update user-level fields
        $userId = (int)$coach['user_id'];
        $userUpdateData = [
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email']
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
                header('Location: ' . url('/coach/edit'));
                exit;
            }
        }

        User::update($userId, $userUpdateData);

        // Handle password change
        $currentPassword = $_POST['current_password'] ?? '';
        $newPassword = $_POST['new_password'] ?? '';
        $confirmPassword = $_POST['confirm_password'] ?? '';

        if (!empty($currentPassword) || !empty($newPassword) || !empty($confirmPassword)) {
            if (empty($currentPassword) || empty($newPassword) || empty($confirmPassword)) {
                Session::flash('error', 'All password fields are required to change password.');
                Session::flash('old', $_POST);
                header('Location: ' . url('/coach/edit'));
                exit;
            }

            if ($newPassword !== $confirmPassword) {
                Session::flash('error', 'New password and confirmation do not match.');
                Session::flash('old', $_POST);
                header('Location: ' . url('/coach/edit'));
                exit;
            }

            if (strlen($newPassword) < 8) {
                Session::flash('error', 'New password must be at least 8 characters.');
                Session::flash('old', $_POST);
                header('Location: ' . url('/coach/edit'));
                exit;
            }

            $user = User::findById($userId);
            if (!$user || !password_verify($currentPassword, $user['password'])) {
                Session::flash('error', 'Current password is incorrect.');
                Session::flash('old', $_POST);
                header('Location: ' . url('/coach/edit'));
                exit;
            }

            User::updatePassword($userId, $newPassword);
        }

        // Update coach-level fields
        Coach::update((int)$coach['id'], [
            'phone' => $data['phone'],
            'address' => $_POST['address'] ?? null,
            'date_of_birth' => $_POST['date_of_birth'] ?? null,
            'qualification' => $_POST['qualification'] ?? null,
            'years_experience' => (int)($_POST['years_experience'] ?? 0),
            'coaching_specialty' => $_POST['coaching_specialty'] ?? null
        ]);

        // Refresh session user data
        $updatedUser = User::findById($userId);
        if ($updatedUser) {
            unset($updatedUser['password']);
            Session::setUser($updatedUser);
        }

        Session::flash('success', 'Profile updated successfully.');
        header('Location: ' . url('/coach/profile'));
        exit;
    }

    public function showTeam(): void
    {
        $coach = $this->getCoach();
        if (!$coach) {
            echo "Coach profile not found.";
            return;
        }

        $team = null;
        $players = [];

        if ($coach['team_id']) {
            $team = Team::findById((int)$coach['team_id']);
            $players = Team::getRoster((int)$coach['team_id']);
        }

        $pageTitle = 'My Team Roster';
        ob_start();
        require __DIR__ . '/../../views/pages/team-roster.php';
        $content = ob_get_clean();
        require __DIR__ . '/../../views/layouts/coach.php';
    }

    public function showPlayer(int $id): void
    {
        $coach = $this->getCoach();
        if (!$coach) {
            echo "Coach profile not found.";
            return;
        }

        $player = Player::findById($id);
        if (!$player) {
            echo "Player not found.";
            return;
        }

        // Ensure player belongs to coach's team
        if ($player['team_id'] !== $coach['team_id']) {
            echo "Player not found on your team.";
            return;
        }

        $pageTitle = 'Player Detail - MARU';
        ob_start();
        require __DIR__ . '/../../views/pages/coach-player-detail.php';
        $content = ob_get_clean();
        require __DIR__ . '/../../views/layouts/coach.php';
    }

    public function announcements(): void
    {
        $coach = $this->getCoach();
        if (!$coach) {
            echo "Coach profile not found.";
            return;
        }

        $teamId = $coach['team_id'] ?? null;
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
        $stmt->execute(['uid' => Session::getUserId(), 'tid' => $teamId ?? 0]);
        $announcements = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        foreach ($announcements as $ann) {
            if (!$ann['is_read_by_me']) {
                $stmt2 = $db->prepare("INSERT IGNORE INTO notification_reads (notification_id, user_id) VALUES (:nid, :uid)");
                $stmt2->execute(['nid' => $ann['id'], 'uid' => Session::getUserId()]);
            }
        }

        $pageTitle = 'Announcements - MARU';
        ob_start();
        require __DIR__ . '/../../views/pages/coach-announcements.php';
        $content = ob_get_clean();
        require __DIR__ . '/../../views/layouts/coach.php';
    }
}
