<?php

declare(strict_types=1);

namespace App\Models;

use App\Config\Database;
use PDO;

class Team
{
    /**
     * Get all teams
     *
     * @return array List of all teams
     */
    public static function getAll(): array
    {
        $db = Database::getConnection();
        $stmt = $db->query("
            SELECT t.*, 
                   u.first_name as coach_first_name, 
                   u.last_name as coach_last_name,
                   u.avatar as coach_avatar,
                   (SELECT COUNT(*) FROM players p WHERE p.team_id = t.id) as player_count
            FROM teams t
            LEFT JOIN coaches c ON t.coach_id = c.id
            LEFT JOIN users u ON c.user_id = u.id
            ORDER BY t.name ASC
        ");
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Find a team by its ID
     *
     * @param int $teamId The ID of the team
     * @return array|null The team data or null if not found
     */
    public static function findById(int $teamId): ?array
    {
        $db = Database::getConnection();
        $stmt = $db->prepare("
            SELECT t.*, u.first_name as coach_first_name, u.last_name as coach_last_name
            FROM teams t
            LEFT JOIN coaches c ON t.coach_id = c.id
            LEFT JOIN users u ON c.user_id = u.id
            WHERE t.id = :id
        ");
        $stmt->execute([':id' => $teamId]);

        $team = $stmt->fetch(PDO::FETCH_ASSOC);
        return $team ?: null;
    }

    /**
     * Create a new team
     *
     * @param array $data The team data
     * @return bool True on success, false on failure
     */
    public static function create(array $data): ?int
    {
        $db = Database::getConnection();
        $stmt = $db->prepare("
            INSERT INTO teams (name, division, max_players)
            VALUES (:name, :division, :max_players)
        ");

        $success = $stmt->execute([
            ':name' => $data['name'],
            ':division' => $data['division'] ?? null,
            ':max_players' => $data['max_players'] ?? 30
        ]);

        return $success ? (int)$db->lastInsertId() : null;
    }

    /**
     * Assign a coach to a team
     *
     * @param int $teamId The ID of the team
     * @param int $coachId The ID of the coach
     * @return bool True on success, false on failure
     */
    public static function assignCoach(int $teamId, int $coachId): bool
    {
        $db = Database::getConnection();
        $stmt = $db->prepare("
            UPDATE teams
            SET coach_id = :coach_id
            WHERE id = :team_id
        ");

        return $stmt->execute([
            ':team_id' => $teamId,
            ':coach_id' => $coachId
        ]);
    }

    /**
     * Get the roster of a team
     *
     * @param int $teamId The ID of the team
     * @return array List of players in the team
     */
    public static function getRoster(int $teamId): array
    {
        $db = Database::getConnection();
        $stmt = $db->prepare("
            SELECT p.*, u.first_name, u.last_name, u.email
            FROM players p
            JOIN users u ON p.user_id = u.id
            WHERE p.team_id = :team_id
        ");
        $stmt->execute([':team_id' => $teamId]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Get total count of teams
     */
    public static function count(): int
    {
        $db = Database::getConnection();
        $stmt = $db->query("SELECT COUNT(*) FROM teams");
        return (int) $stmt->fetchColumn();
    }
}
