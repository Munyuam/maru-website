<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Helpers\Session;
use App\Helpers\FileUpload;
use App\Helpers\Validator;
use App\Config\Database;
use App\Models\Coach;
use App\Models\Document;
use App\Models\Player;
use App\Models\Post;
use App\Models\Team;
use App\Models\User;
use PDO;

/**
 * Class AdminController
 *
 * Handles administrative actions for the MARU Web-Based Online Player Registration System.
 */
class AdminController
{
    /**
     * Renders a view with the given data and layout.
     * This is a simple helper function, assuming the framework expects it.
     * 
     * @param string $view
     * @param array $data
     * @param string $layout
     */
    protected function render(string $view, array $data = [], string $layout = 'admin'): void
    {
        extract($data);
        $contentView = __DIR__ . "/../../views/pages/{$view}.php";
        
        if (!file_exists($contentView)) {
            echo "View {$view} not found.";
            return;
        }

        ob_start();
        require $contentView;
        $content = ob_get_clean();

        require __DIR__ . "/../../views/layouts/{$layout}.php";
    }

    /**
     * Dashboard page showing high-level stats.
     */
    public function dashboard(): void
    {
        $db = Database::getConnection();
        
        $recentPlayersStmt = $db->query("
            SELECT p.*, u.first_name, u.last_name, u.avatar 
            FROM players p 
            JOIN users u ON p.user_id = u.id 
            ORDER BY p.registered_at DESC 
            LIMIT 5
        ");
        $recentPlayers = $recentPlayersStmt->fetchAll(PDO::FETCH_ASSOC);
        
        $pendingItems = [];
        
        $pendingPlayersStmt = $db->query("
            SELECT COUNT(*) FROM players WHERE registration_status = 'pending'
        ");
        $pendingPlayerCount = (int) $pendingPlayersStmt->fetchColumn();
        if ($pendingPlayerCount > 0) {
            $pendingItems[] = [
                'action' => 'Player Registration Review',
                'user' => $pendingPlayerCount . ' player' . ($pendingPlayerCount > 1 ? 's' : ''),
                'status' => 'Pending',
                'badgeClass' => 'badge-warning',
                'icon' => 'ph-users'
            ];
        }
        
        $pendingDocsStmt = $db->query("
            SELECT COUNT(*) FROM documents WHERE verification_status = 'pending'
        ");
        $pendingDocCount = (int) $pendingDocsStmt->fetchColumn();
        if ($pendingDocCount > 0) {
            $pendingItems[] = [
                'action' => 'Document Verification',
                'user' => $pendingDocCount . ' document' . ($pendingDocCount > 1 ? 's' : ''),
                'status' => 'Pending',
                'badgeClass' => 'badge-warning',
                'icon' => 'ph-file-text'
            ];
        }
        
        $pendingCoachesStmt = $db->query("
            SELECT COUNT(*) FROM coaches WHERE registration_status = 'pending'
        ");
        $pendingCoachCount = (int) $pendingCoachesStmt->fetchColumn();
        if ($pendingCoachCount > 0) {
            $pendingItems[] = [
                'action' => 'Coach Application Review',
                'user' => $pendingCoachCount . ' coach' . ($pendingCoachCount > 1 ? 'es' : ''),
                'status' => 'Pending',
                'badgeClass' => 'badge-warning',
                'icon' => 'ph-chalkboard-teacher'
            ];
        }
        
        $unassignedTeamsStmt = $db->query("
            SELECT COUNT(*) FROM teams WHERE coach_id IS NULL
        ");
        $unassignedTeamCount = (int) $unassignedTeamsStmt->fetchColumn();
        if ($unassignedTeamCount > 0) {
            $pendingItems[] = [
                'action' => 'Team Coach Assignment',
                'user' => $unassignedTeamCount . ' team' . ($unassignedTeamCount > 1 ? 's' : ''),
                'status' => 'Action Required',
                'badgeClass' => 'badge-danger',
                'icon' => 'ph-trophy'
            ];
        }

        $data = [
            'totalPlayers' => Player::count() ?? 0,
            'pendingRegistrations' => Player::countPending() ?? 0,
            'totalTeams' => Team::count() ?? 0,
            'totalCoaches' => Coach::count() ?? 0,
            'recentPlayers' => $recentPlayers,
            'pendingItems' => $pendingItems,
            'pageTitle' => 'Admin Dashboard'
        ];
        
        $this->render('admin/dashboard', $data);
    }

    /**
     * Show form to create a new player (by admin).
     */
    public function createPlayerForm(): void
    {
        $teams = Team::getAll();
        $this->render('admin/player-form', ['teams' => $teams, 'pageTitle' => 'Add Player']);
    }

    /**
     * Handle admin creating a new player.
     */
    public function createPlayer(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . url('/admin/players/create'));
            exit;
        }

        $csrf = $_POST['csrf_token'] ?? '';
        if (!Session::validateCsrfToken($csrf)) {
            Session::setFlash('error', 'Invalid security token.');
            header('Location: ' . url('/admin/players/create'));
            exit;
        }

        $validator = new \App\Helpers\Validator($_POST);
        $validator->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
            'first_name' => 'required',
            'last_name' => 'required',
            'date_of_birth' => 'required',
            'gender' => 'required',
            'nationality' => 'required',
            'phone' => 'required',
            'position' => 'required'
        ]);

        if ($validator->hasErrors()) {
            Session::setFlash('errors', $validator->errors());
            Session::setFlash('old', $_POST);
            header('Location: ' . url('/admin/players/create'));
            exit;
        }

        $data = $validator->validated();

        if (\App\Models\User::findByEmail($data['email'])) {
            Session::setFlash('error', 'Email is already registered.');
            Session::setFlash('old', $_POST);
            header('Location: ' . url('/admin/players/create'));
            exit;
        }

        $userId = \App\Models\User::create([
            'email' => $data['email'],
            'password' => $data['password'],
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'role' => 'player',
            'phone' => $data['phone']
        ]);

        if ($userId) {
            $playerCreated = \App\Models\Player::create($userId, [
                'date_of_birth' => $data['date_of_birth'],
                'gender' => $data['gender'],
                'nationality' => $data['nationality'],
                'phone' => $data['phone'],
                'position' => $data['position'],
                'team_id' => !empty($_POST['team_id']) ? (int)$_POST['team_id'] : null
            ]);

            if ($playerCreated) {
                Session::setFlash('success', 'Player created successfully.');
                header('Location: ' . url('/admin/players'));
                exit;
            }
        }

        Session::setFlash('error', 'Failed to create player.');
        header('Location: ' . url('/admin/players/create'));
        exit;
    }

    /**
     * Show form to create a new coach (by admin).
     */
    public function createCoachForm(): void
    {
        $teams = \App\Models\Team::getAll();
        $this->render('admin/coach-form', ['teams' => $teams, 'pageTitle' => 'Add Coach']);
    }

    /**
     * Handle admin creating a new coach.
     */
    public function createCoach(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . url('/admin/coaches/create'));
            exit;
        }

        $csrf = $_POST['csrf_token'] ?? '';
        if (!Session::validateCsrfToken($csrf)) {
            Session::setFlash('error', 'Invalid security token.');
            header('Location: ' . url('/admin/coaches/create'));
            exit;
        }

        $validator = new \App\Helpers\Validator($_POST);
        $validator->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
            'first_name' => 'required',
            'last_name' => 'required',
            'phone' => 'required',
            'date_of_birth' => 'required',
            'qualification' => 'required',
            'years_experience' => 'required',
            'coaching_specialty' => 'required'
        ]);

        if ($validator->hasErrors()) {
            Session::setFlash('errors', $validator->errors());
            Session::setFlash('old', $_POST);
            header('Location: ' . url('/admin/coaches/create'));
            exit;
        }

        $data = $validator->validated();

        if (\App\Models\User::findByEmail($data['email'])) {
            Session::setFlash('error', 'Email is already registered.');
            Session::setFlash('old', $_POST);
            header('Location: ' . url('/admin/coaches/create'));
            exit;
        }

        $userId = \App\Models\User::create([
            'email' => $data['email'],
            'password' => $data['password'],
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'role' => 'coach',
            'phone' => $data['phone']
        ]);

        if ($userId) {
            $coachCreated = \App\Models\Coach::create($userId, [
                'phone' => $data['phone'],
                'address' => $_POST['address'] ?? null,
                'date_of_birth' => $data['date_of_birth'],
                'qualification' => $data['qualification'],
                'years_experience' => (int)$data['years_experience'],
                'coaching_specialty' => $data['coaching_specialty'],
                'team_id' => !empty($_POST['team_id']) ? (int)$_POST['team_id'] : null
            ]);

            if ($coachCreated) {
                Session::setFlash('success', 'Coach created successfully.');
                header('Location: ' . url('/admin/coaches'));
                exit;
            }
        }

        Session::setFlash('error', 'Failed to create coach.');
        header('Location: ' . url('/admin/coaches/create'));
        exit;
    }

    /**
     * Show form to create a new admin (by admin).
     */
    public function createAdminForm(): void
    {
        $this->render('admin/admin-form', ['pageTitle' => 'Add Admin']);
    }

    /**
     * Handle admin creating another admin.
     */
    public function createAdmin(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . url('/admin/admins/create'));
            exit;
        }

        $csrf = $_POST['csrf_token'] ?? '';
        if (!Session::validateCsrfToken($csrf)) {
            Session::setFlash('error', 'Invalid security token.');
            header('Location: ' . url('/admin/admins/create'));
            exit;
        }

        $validator = new \App\Helpers\Validator($_POST);
        $validator->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
            'first_name' => 'required',
            'last_name' => 'required'
        ]);

        if ($validator->hasErrors()) {
            Session::setFlash('errors', $validator->errors());
            Session::setFlash('old', $_POST);
            header('Location: ' . url('/admin/admins/create'));
            exit;
        }

        $data = $validator->validated();

        if (\App\Models\User::findByEmail($data['email'])) {
            Session::setFlash('error', 'Email is already registered.');
            Session::setFlash('old', $_POST);
            header('Location: ' . url('/admin/admins/create'));
            exit;
        }

        $userId = \App\Models\User::create([
            'email' => $data['email'],
            'password' => $data['password'],
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'role' => 'admin'
        ]);

        if ($userId) {
            Session::setFlash('success', 'Admin created successfully.');
            header('Location: ' . url('/admin'));
            exit;
        }

        Session::setFlash('error', 'Failed to create admin.');
        header('Location: ' . url('/admin/admins/create'));
        exit;
    }

    /**
     * Show admin profile page.
     */
    public function profile(): void
    {
        $userId = Session::getUserId();
        $user = User::findById($userId);

        if (!$user) {
            Session::setFlash('error', 'User not found.');
            header('Location: ' . url('/admin'));
            exit;
        }

        $this->render('admin/profile', [
            'user' => $user,
            'pageTitle' => 'My Profile'
        ]);
    }

    /**
     * Update admin profile details.
     */
    public function updateProfile(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . url('/admin/profile'));
            exit;
        }

        $userId = Session::getUserId();
        $firstName = trim($_POST['first_name'] ?? '');
        $lastName = trim($_POST['last_name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $phone = trim($_POST['phone'] ?? '');

        if (empty($firstName) || empty($lastName) || empty($email)) {
            Session::setFlash('error', 'First name, last name, and email are required.');
            header('Location: ' . url('/admin/profile'));
            exit;
        }

        $existingUser = User::findByEmail($email);
        if ($existingUser && (int)$existingUser['id'] !== $userId) {
            Session::setFlash('error', 'Email is already in use.');
            header('Location: ' . url('/admin/profile'));
            exit;
        }

        $updateData = [
            'first_name' => $firstName,
            'last_name' => $lastName,
            'email' => $email,
            'phone' => $phone,
        ];

        if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = UPLOAD_DIR . '/avatars';
            $result = FileUpload::upload($_FILES['avatar'], $uploadDir, ['jpg', 'jpeg', 'png'], MAX_FILE_SIZE);
            
            if ($result['success']) {
                $updateData['avatar'] = $result['file_path'];
            } else {
                Session::setFlash('error', 'Avatar upload failed: ' . $result['error']);
                header('Location: ' . url('/admin/profile'));
                exit;
            }
        }

        if (User::update($userId, $updateData)) {
            $updatedUser = User::findById($userId);
            Session::setUser($updatedUser);
            Session::setFlash('success', 'Profile updated successfully.');
        } else {
            Session::setFlash('error', 'Failed to update profile.');
        }

        header('Location: ' . url('/admin/profile'));
        exit;
    }

    /**
     * Change admin password.
     */
    public function changePassword(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . url('/admin/profile'));
            exit;
        }

        $userId = Session::getUserId();
        $currentPassword = $_POST['current_password'] ?? '';
        $newPassword = $_POST['new_password'] ?? '';
        $confirmPassword = $_POST['confirm_password'] ?? '';

        if (empty($currentPassword) || empty($newPassword) || empty($confirmPassword)) {
            Session::setFlash('error', 'All password fields are required.');
            header('Location: ' . url('/admin/profile'));
            exit;
        }

        if ($newPassword !== $confirmPassword) {
            Session::setFlash('error', 'New passwords do not match.');
            header('Location: ' . url('/admin/profile'));
            exit;
        }

        if (strlen($newPassword) < 8) {
            Session::setFlash('error', 'Password must be at least 8 characters long.');
            header('Location: ' . url('/admin/profile'));
            exit;
        }

        $user = User::findById($userId);
        if (!$user || !password_verify($currentPassword, $user['password'])) {
            Session::setFlash('error', 'Current password is incorrect.');
            header('Location: ' . url('/admin/profile'));
            exit;
        }

        if (User::updatePassword($userId, $newPassword)) {
            Session::setFlash('success', 'Password changed successfully.');
        } else {
            Session::setFlash('error', 'Failed to change password.');
        }

        header('Location: ' . url('/admin/profile'));
        exit;
    }

    /**
     * List all players with optional filters.
     */
    public function players(): void
    {
        $page = max(1, (int)($_GET['page'] ?? 1));
        $filters = [];
        
        if (!empty($_GET['team_id'])) {
            $filters['team_id'] = (int)$_GET['team_id'];
        }
        if (!empty($_GET['status'])) {
            $filters['status'] = $_GET['status'];
        }

        $players = Player::getAll($filters, $page) ?? [];
        
        $totalPlayers = Player::count();
        $perPage = 20;
        $totalPages = max(1, (int)ceil($totalPlayers / $perPage));
        
        $this->render('admin/players', [
            'players' => $players, 
            'pageTitle' => 'Players List',
            'currentPage' => $page,
            'totalPages' => $totalPages
        ]);
    }

    /**
     * Show detailed profile for a specific player.
     * 
     * @param int|string $id
     */
    public function playerDetail($id): void
    {
        $player = Player::findById((int)$id); // Assuming findById() exists
        
        if (!$player) {
            Session::setFlash('error', 'Player not found.');
            header('Location: ' . url('/admin/players'));
            exit;
        }

        $this->render('admin/player-detail', ['player' => $player, 'pageTitle' => 'Player Profile']);
    }

    /**
     * Update the registration status of a player.
     * 
     * @param int|string $id
     */
    public function updatePlayerStatus($id): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $csrf = $_POST['csrf_token'] ?? '';
            if (!Session::validateCsrfToken($csrf)) {
                Session::setFlash('error', 'Invalid security token.');
                header('Location: ' . url("/admin/players/{$id}"));
                exit;
            }

            $status = $_POST['status'] ?? '';
            $notes = $_POST['notes'] ?? '';
            
            if (in_array($status, ['approved', 'rejected', 'pending'])) {
                $updateData = ['registration_status' => $status];
                if (!empty($notes)) {
                    $updateData['registration_notes'] = $notes;
                }
                if (Player::update((int)$id, $updateData)) {
                    Session::setFlash('success', "Player status updated to {$status}.");
                } else {
                    Session::setFlash('error', 'Failed to update player status.');
                }
            } else {
                Session::setFlash('error', 'Invalid status provided.');
            }
        }
        
        header('Location: ' . url("/admin/players/{$id}"));
        exit;
    }

    /**
     * List all coaches.
     */
    public function coaches(): void
    {
        $coaches = Coach::all() ?? [];
        
        $this->render('admin/coaches', ['coaches' => $coaches, 'pageTitle' => 'Coaches List']);
    }

    /**
     * Show detailed profile for a specific coach.
     * 
     * @param int|string $id
     */
    public function coachDetail($id): void
    {
        $coach = Coach::findById((int)$id); // Assuming findById() exists
        
        if (!$coach) {
            Session::setFlash('error', 'Coach not found.');
            header('Location: ' . url('/admin/coaches'));
            exit;
        }

        $this->render('admin/coach-detail', ['coach' => $coach, 'pageTitle' => 'Coach Profile']);
    }

    /**
     * Update the registration status of a coach.
     * 
     * @param int|string $id
     */
    public function updateCoachStatus($id): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $csrf = $_POST['csrf_token'] ?? '';
            if (!Session::validateCsrfToken($csrf)) {
                Session::setFlash('error', 'Invalid security token.');
                header('Location: ' . url("/admin/coaches/{$id}"));
                exit;
            }

            $status = $_POST['status'] ?? '';
            
            if (in_array($status, ['approved', 'rejected', 'pending'])) {
                $db = Database::getConnection();
                $stmt = $db->prepare("UPDATE coaches SET registration_status = :status WHERE id = :id");
                $success = $stmt->execute([':status' => $status, ':id' => (int)$id]);
                
                if ($success) {
                    Session::setFlash('success', "Coach status updated to {$status}.");
                } else {
                    Session::setFlash('error', 'Failed to update coach status.');
                }
            } else {
                Session::setFlash('error', 'Invalid status provided.');
            }
        }
        
        header('Location: ' . url("/admin/coaches/{$id}"));
        exit;
    }

    /**
     * List all teams.
     */
    public function teams(): void
    {
        $teams = Team::getAll() ?? [];
        
        $this->render('admin/teams', ['teams' => $teams, 'pageTitle' => 'Teams List']);
    }

    /**
     * Show form to create a new team.
     */
    public function createTeamForm(): void
    {
        $coaches = Coach::all() ?? [];
        $this->render('admin/team-form', ['pageTitle' => 'Create Team', 'coaches' => $coaches]);
    }

    /**
     * Handle creation of a new team.
     */
    public function createTeam(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $csrf = $_POST['csrf_token'] ?? '';
            if (!Session::validateCsrfToken($csrf)) {
                Session::setFlash('error', 'Invalid security token.');
                header('Location: ' . url('/admin/teams/create'));
                exit;
            }

            $name = trim($_POST['name'] ?? '');
            $division = trim($_POST['division'] ?? '');
            $maxPlayers = (int)($_POST['max_players'] ?? 22);
            $coachId = !empty($_POST['coach_id']) ? (int)$_POST['coach_id'] : null;

            if (empty($name)) {
                Session::setFlash('error', 'Team name is required.');
                header('Location: ' . url('/admin/teams/create'));
                exit;
            }

            $teamId = Team::create([
                'name' => $name,
                'division' => $division,
                'max_players' => $maxPlayers
            ]);

            if ($teamId) {
                if ($coachId) {
                    Team::assignCoach($teamId, $coachId);
                }
                Session::setFlash('success', 'Team created successfully.');
                header('Location: ' . url('/admin/teams'));
                exit;
            } else {
                Session::setFlash('error', 'Failed to create team.');
                header('Location: ' . url('/admin/teams/create'));
                exit;
            }
        }
        
        header('Location: ' . url('/admin/teams'));
        exit;
    }

    /**
     * Show details for a specific team, including roster.
     * 
     * @param int|string $id
     */
    public function teamDetail($id): void
    {
        $team = Team::findById((int)$id); // Assuming findById() exists
        
        if (!$team) {
            Session::setFlash('error', 'Team not found.');
            header('Location: ' . url('/admin/teams'));
            exit;
        }
        
        $roster = Team::getRoster((int)$id);

        $this->render('admin/team-detail', ['team' => $team, 'roster' => $roster, 'pageTitle' => 'Team Details']);
    }

    /**
     * List pending documents for verification.
     */
    public function documents(): void
    {
        $pendingDocuments = Document::getPending();
        
        $this->render('admin/documents', ['pendingDocuments' => $pendingDocuments, 'pageTitle' => 'Document Verification']);
    }

    /**
     * Verify a specific document.
     * 
     * @param int|string $id
     */
    public function verifyDocument($id): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $csrf = $_POST['csrf_token'] ?? '';
            if (!Session::validateCsrfToken($csrf)) {
                Session::setFlash('error', 'Invalid security token.');
                header('Location: ' . url('/admin/documents'));
                exit;
            }

            $status = $_POST['status'] ?? 'pending';
            $notes = $_POST['notes'] ?? null;
            $adminId = Session::getUser()['id'] ?? null;

            if (in_array($status, ['verified', 'rejected'])) {
                if (Document::updateStatus((int)$id, $status, $adminId, $notes)) {
                    Session::setFlash('success', 'Document verified successfully.');
                } else {
                    Session::setFlash('error', 'Failed to verify document.');
                }
            } else {
                Session::setFlash('error', 'Invalid verification status.');
            }
        }
        
        header('Location: ' . url('/admin/documents'));
        exit;
    }

    /**
     * List all announcements.
     */
    public function announcements(): void
    {
        $db = Database::getConnection();
        $stmt = $db->query("
            SELECT n.*, u.first_name, u.last_name, t.name AS team_name
            FROM notifications n
            JOIN users u ON n.sender_id = u.id
            LEFT JOIN teams t ON n.target_type = 'team' AND n.target_id = t.id
            WHERE n.user_id = 0
            ORDER BY n.created_at DESC
        ");
        $announcements = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        $this->render('admin/announcements', [
            'announcements' => $announcements,
            'pageTitle' => 'Announcements'
        ]);
    }

    /**
     * Show form to create an announcement.
     */
    public function createAnnouncementForm(): void
    {
        $teams = Team::getAll();
        $this->render('admin/announcement-form', [
            'pageTitle' => 'Create Announcement',
            'teams' => $teams
        ]);
    }

    /**
     * Handle creating a new announcement.
     */
    public function createAnnouncement(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = $_POST['title'] ?? '';
            $message = $_POST['message'] ?? '';
            $type = $_POST['type'] ?? 'info';
            $targetType = $_POST['target_type'] ?? 'all';
            $targetId = ($targetType === 'team' && !empty($_POST['target_id'])) ? (int)$_POST['target_id'] : null;
            $adminId = Session::getUserId();

            if (empty($title) || empty($message)) {
                Session::setFlash('error', 'Title and message are required.');
                header('Location: ' . url('/admin/announcements/create'));
                exit;
            }

            try {
                $db = Database::getConnection();
                $stmt = $db->prepare("INSERT INTO notifications (user_id, sender_id, title, message, type, target_type, target_id, created_at) VALUES (0, :sender_id, :title, :message, :type, :target_type, :target_id, NOW())");
                $stmt->execute([
                    'sender_id' => $adminId,
                    'title' => $title,
                    'message' => $message,
                    'type' => $type,
                    'target_type' => $targetType,
                    'target_id' => $targetId
                ]);
                Session::setFlash('success', 'Announcement published successfully.');
            } catch (\Exception $e) {
                Session::setFlash('error', 'Failed to create announcement.');
            }
        }
        header('Location: ' . url('/admin/announcements'));
        exit;
    }

    /**
     * Send a notification to a specific user.
     */
    public function sendNotification(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $csrf = $_POST['csrf_token'] ?? '';
            if (!Session::validateCsrfToken($csrf)) {
                Session::setFlash('error', 'Invalid security token.');
                $redirect = $_SERVER['HTTP_REFERER'] ?? '/admin';
                header("Location: {$redirect}");
                exit;
            }

            $userId = $_POST['user_id'] ?? null;
            $title = $_POST['title'] ?? '';
            $message = $_POST['message'] ?? '';
            
            if ($userId && $title && $message) {
                try {
                    $db = Database::getConnection();
                    $stmt = $db->prepare("INSERT INTO notifications (user_id, title, message, created_at) VALUES (?, ?, ?, NOW())");
                    $stmt->execute([$userId, $title, $message]);
                    
                    Session::setFlash('success', 'Notification sent successfully.');
                } catch (\Exception $e) {
                    Session::setFlash('error', 'Failed to send notification. Please try again.');
                }
            } else {
                Session::setFlash('error', 'All fields are required to send a notification.');
            }
        }
        
        // Redirect back (wherever they came from, or dashboard as fallback)
        $redirect = $_SERVER['HTTP_REFERER'] ?? '/admin/dashboard';
        header("Location: {$redirect}");
        exit;
    }

    public function posts(): void
    {
        $posts = Post::findAll();
        $this->render('admin/posts', [
            'posts' => $posts,
            'pageTitle' => 'Posts'
        ]);
    }

    public function createPostForm(): void
    {
        $this->render('admin/post-form', [
            'post' => null,
            'pageTitle' => 'Create Post'
        ]);
    }

    public function createPost(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . url('/admin/posts/create'));
            exit;
        }

        $title = $_POST['title'] ?? '';
        $body = $_POST['body'] ?? '';
        if (empty($title) || empty($body)) {
            Session::setFlash('error', 'Title and body are required.');
            header('Location: ' . url('/admin/posts/create'));
            exit;
        }

        $image = null;
        if (!empty($_FILES['image']['name'])) {
            $uploadDir = UPLOAD_DIR . '/posts';
            $result = FileUpload::upload($_FILES['image'], $uploadDir, ['jpg', 'jpeg', 'png'], MAX_FILE_SIZE);
            if (!$result['success']) {
                Session::setFlash('error', 'Image upload failed: ' . ($result['error'] ?? 'unknown error'));
                header('Location: ' . url('/admin/posts/create'));
                exit;
            }
            $image = $result['file_path'];
        }

        $isPublished = !empty($_POST['is_published']) ? 1 : 0;
        try {
            Post::create([
                'title' => $title,
                'excerpt' => $_POST['excerpt'] ?? null,
                'body' => $body,
                'image' => $image,
                'author_id' => Session::getUserId(),
                'is_published' => $isPublished,
                'published_at' => $isPublished ? date('Y-m-d H:i:s') : null,
            ]);
            Session::setFlash('success', 'Post created successfully.');
        } catch (\Exception $e) {
            Session::setFlash('error', 'Failed to create post.');
        }
        header('Location: ' . url('/admin/posts'));
        exit;
    }

    public function editPostForm(int $id): void
    {
        $post = Post::findById($id);
        if (!$post) {
            Session::setFlash('error', 'Post not found.');
            header('Location: ' . url('/admin/posts'));
            exit;
        }
        $this->render('admin/post-form', [
            'post' => $post,
            'pageTitle' => 'Edit Post'
        ]);
    }

    public function updatePost(int $id): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . url('/admin/posts'));
            exit;
        }

        $post = Post::findById($id);
        if (!$post) {
            Session::setFlash('error', 'Post not found.');
            header('Location: ' . url('/admin/posts'));
            exit;
        }

        $data = [
            'title' => $_POST['title'] ?? '',
            'excerpt' => $_POST['excerpt'] ?? null,
            'body' => $_POST['body'] ?? '',
        ];

        if (empty($data['title']) || empty($data['body'])) {
            Session::setFlash('error', 'Title and body are required.');
            header('Location: ' . url('/admin/posts/edit/' . $id));
            exit;
        }

        $isPublished = !empty($_POST['is_published']) ? 1 : 0;
        $data['is_published'] = $isPublished;
        if ($isPublished && empty($post['published_at'])) {
            $data['published_at'] = date('Y-m-d H:i:s');
        }

        if (!empty($_FILES['image']['name'])) {
            $uploadDir = UPLOAD_DIR . '/posts';
            $result = FileUpload::upload($_FILES['image'], $uploadDir, ['jpg', 'jpeg', 'png'], MAX_FILE_SIZE);
            if (!$result['success']) {
                Session::setFlash('error', 'Image upload failed: ' . ($result['error'] ?? 'unknown error'));
                header('Location: ' . url('/admin/posts/edit/' . $id));
                exit;
            }
            $data['image'] = $result['file_path'];
            // Delete old image
            if (!empty($post['image'])) {
                $oldPath = UPLOAD_DIR . '/posts/' . $post['image'];
                if (file_exists($oldPath)) unlink($oldPath);
            }
        }

        try {
            Post::update($id, $data);
            Session::setFlash('success', 'Post updated successfully.');
        } catch (\Exception $e) {
            Session::setFlash('error', 'Failed to update post.');
        }
        header('Location: ' . url('/admin/posts'));
        exit;
    }

    public function deletePost(int $id): void
    {
        $post = Post::findById($id);
        if ($post) {
            if (!empty($post['image'])) {
                $path = UPLOAD_DIR . '/posts/' . $post['image'];
                if (file_exists($path)) unlink($path);
            }
            Post::delete($id);
            Session::setFlash('success', 'Post deleted.');
        } else {
            Session::setFlash('error', 'Post not found.');
        }
        header('Location: ' . url('/admin/posts'));
        exit;
    }

    public function togglePost(int $id): void
    {
        $post = Post::findById($id);
        if ($post) {
            $newStatus = $post['is_published'] ? 0 : 1;
            $data = ['is_published' => $newStatus];
            if ($newStatus && empty($post['published_at'])) {
                $data['published_at'] = date('Y-m-d H:i:s');
            }
            Post::update($id, $data);
            Session::setFlash('success', 'Post ' . ($newStatus ? 'published' : 'unpublished') . '.');
        } else {
            Session::setFlash('error', 'Post not found.');
        }
        header('Location: ' . url('/admin/posts'));
        exit;
    }
}
