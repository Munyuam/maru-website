<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Helpers\Session;
use App\Models\Coach;
use App\Models\Team;

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

        $pageTitle = 'Coach Profile';
        ob_start();
        require __DIR__ . '/../../views/pages/coach-profile.php';
        $content = ob_get_clean();
        require __DIR__ . '/../../views/layouts/main.php';
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
        require __DIR__ . '/../../views/layouts/main.php';
    }

    public function updateProfile(): void
    {
        $coach = $this->getCoach();
        if (!$coach) {
            echo "Coach profile not found.";
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /coach/edit');
            exit;
        }

        $csrf = $_POST['csrf_token'] ?? '';
        if (!\App\Helpers\Session::validateCsrfToken($csrf)) {
            Session::flash('error', 'Invalid security token.');
            header('Location: /coach/edit');
            exit;
        }

        $data = [
            'phone' => $_POST['phone'] ?? $coach['phone'],
            'address' => $_POST['address'] ?? $coach['address'],
            'qualification' => $_POST['qualification'] ?? $coach['qualification'],
            'years_experience' => (int)($_POST['years_experience'] ?? $coach['years_experience']),
            'coaching_specialty' => $_POST['coaching_specialty'] ?? $coach['coaching_specialty'],
        ];

        if (\App\Models\Coach::update((int)$coach['id'], $data)) {
            Session::flash('success', 'Profile updated successfully.');
            header('Location: /coach/profile');
        } else {
            Session::flash('error', 'Failed to update profile.');
            header('Location: /coach/edit');
        }
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
        require __DIR__ . '/../../views/layouts/main.php';
    }
}
