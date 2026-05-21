<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Helpers\Session;
use App\Models\Coach;
use App\Models\Team;

class CoachController
{
    /**
     * Show coach profile
     */
    public function showProfile(): void
    {
        // Must be logged in and a coach
        if (!Session::get('user_id') || Session::get('role') !== 'coach') {
            header('Location: /login');
            exit;
        }

        $userId = Session::get('user_id');
        $coach = Coach::findByUserId($userId);

        if (!$coach) {
            // Handle error, coach profile not found
            echo "Coach profile not found.";
            return;
        }

        $title = 'Coach Profile';
        $content = __DIR__ . '/../views/pages/coach-profile.php';
        require __DIR__ . '/../views/layouts/main.php';
    }

    /**
     * Show coach's team and roster
     */
    public function showTeam(): void
    {
        // Must be logged in and a coach
        if (!Session::get('user_id') || Session::get('role') !== 'coach') {
            header('Location: /login');
            exit;
        }

        $userId = Session::get('user_id');
        $coach = Coach::findByUserId($userId);

        if (!$coach) {
            echo "Coach profile not found.";
            return;
        }

        $team = null;
        $roster = [];

        if ($coach['team_id']) {
            $team = Team::findById((int)$coach['team_id']);
            $roster = Team::getRoster((int)$coach['team_id']);
        }

        $title = 'My Team Roster';
        $content = __DIR__ . '/../views/pages/team-roster.php';
        require __DIR__ . '/../views/layouts/main.php';
    }
}
