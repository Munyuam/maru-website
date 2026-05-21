<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\Team;

class TeamController
{
    /**
     * Placeholder for future team management functionality
     * Can be used by AJAX endpoints or other components
     */
    public function index(): void
    {
        $teams = Team::getAll();
        header('Content-Type: application/json');
        echo json_encode($teams);
    }
}
