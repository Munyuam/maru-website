<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Helpers\Session;
use App\Models\User;
use App\Models\Player;
use App\Models\Coach;
use App\Models\Team;
use App\Config\Database;
use App\Models\Document;

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
        // Assuming a standard way to load views and layouts in this custom framework
        extract($data);
        $contentView = __DIR__ . "/../../views/pages/{$view}.php";
        
        if (file_exists($contentView)) {
            require_once __DIR__ . "/../../views/layouts/{$layout}.php";
        } else {
            // Handle view not found
            echo "View {$view} not found.";
        }
    }

    /**
     * Dashboard page showing high-level stats.
     */
    public function dashboard(): void
    {
        // Placeholder stats - replace with actual model calls when fully implemented
        $data = [
            'totalPlayers' => Player::count() ?? 0, // Assuming count() method exists
            'pendingRegistrations' => Player::countPending() ?? 0, // Assuming countPending() method exists
            'totalTeams' => Team::count() ?? 0, // Assuming count() method exists
            'pageTitle' => 'Admin Dashboard'
        ];
        
        $this->render('admin/dashboard', $data);
    }

    /**
     * List all players with optional filters.
     */
    public function players(): void
    {
        // Fetch players (with optional filters in the future)
        $players = Player::all() ?? []; // Assuming all() exists
        
        $this->render('admin/players', ['players' => $players, 'pageTitle' => 'Players List']);
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
            header('Location: /admin/players');
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
            $status = $_POST['status'] ?? '';
            
            if (in_array($status, ['approved', 'rejected', 'pending'])) {
                if (Player::update((int)$id, ['status' => $status])) { // Assuming update() exists
                    Session::setFlash('success', "Player status updated to {$status}.");
                } else {
                    Session::setFlash('error', 'Failed to update player status.');
                }
            } else {
                Session::setFlash('error', 'Invalid status provided.');
            }
        }
        
        header("Location: /admin/players/detail/{$id}");
        exit;
    }

    /**
     * List all coaches.
     */
    public function coaches(): void
    {
        $coaches = Coach::all() ?? []; // Assuming all() exists
        
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
            header('Location: /admin/coaches');
            exit;
        }

        $this->render('admin/coach-detail', ['coach' => $coach, 'pageTitle' => 'Coach Profile']);
    }

    /**
     * List all teams.
     */
    public function teams(): void
    {
        $teams = Team::all() ?? []; // Assuming all() exists
        
        $this->render('admin/teams', ['teams' => $teams, 'pageTitle' => 'Teams List']);
    }

    /**
     * Show form to create a new team.
     */
    public function createTeamForm(): void
    {
        $this->render('admin/team-form', ['pageTitle' => 'Create Team']);
    }

    /**
     * Handle creation of a new team.
     */
    public function createTeam(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $teamData = [
                'name' => $_POST['name'] ?? '',
                'age_group' => $_POST['age_group'] ?? '',
                'coach_id' => $_POST['coach_id'] ?? null
            ];
            
            // Basic validation
            if (empty($teamData['name'])) {
                Session::setFlash('error', 'Team name is required.');
                header('Location: /admin/teams/create');
                exit;
            }

            if (Team::create($teamData)) { // Assuming create() exists
                Session::setFlash('success', 'Team created successfully.');
                header('Location: /admin/teams');
                exit;
            } else {
                Session::setFlash('error', 'Failed to create team.');
                header('Location: /admin/teams/create');
                exit;
            }
        }
        
        header('Location: /admin/teams');
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
            header('Location: /admin/teams');
            exit;
        }
        
        // Fetch roster (assuming a method to get players for a team)
        // $roster = Player::findByTeamId((int)$id);
        $roster = []; 

        $this->render('admin/team-detail', ['team' => $team, 'roster' => $roster, 'pageTitle' => 'Team Details']);
    }

    /**
     * List pending documents for verification.
     */
    public function documents(): void
    {
        $pendingDocuments = []; // Empty for now, Document model is Phase 6
        
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
            $status = $_POST['status'] ?? 'pending';
            $notes = $_POST['notes'] ?? null;
            $adminId = Session::getUser()['id'] ?? null;

            if (Document::updateStatus((int)$id, $status, $adminId, $notes)) {
                Session::setFlash('success', 'Document verified successfully.');
            } else {
                Session::setFlash('error', 'Failed to verify document.');
            }
        }
        
        header('Location: /admin/documents');
        exit;
    }

    /**
     * Send a notification to a specific user.
     */
    public function sendNotification(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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
                    Session::setFlash('error', 'Failed to send notification: ' . $e->getMessage());
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
}
