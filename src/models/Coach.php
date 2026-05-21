<?php

declare(strict_types=1);

namespace App\Models;

use App\Config\Database;
use PDO;

class Coach
{
    /**
     * Create a new coach profile
     *
     * @param int $userId The ID of the user
     * @param array $data The coach data
     * @return bool True on success, false on failure
     */
    public static function create(int $userId, array $data): bool
    {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("
            INSERT INTO coaches (user_id, team_id, phone, address)
            VALUES (:user_id, :team_id, :phone, :address)
        ");

        return $stmt->execute([
            ':user_id' => $userId,
            ':team_id' => $data['team_id'] ?? null,
            ':phone' => $data['phone'] ?? null,
            ':address' => $data['address'] ?? null
        ]);
    }

    /**
     * Find a coach by their user ID
     *
     * @param int $userId The user ID
     * @return array|null The coach data or null if not found
     */
    public static function findByUserId(int $userId): ?array
    {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("
            SELECT c.*, u.first_name, u.last_name, u.email, t.name as team_name
            FROM coaches c
            JOIN users u ON c.user_id = u.id
            LEFT JOIN teams t ON c.team_id = t.id
            WHERE c.user_id = :user_id
        ");
        $stmt->execute([':user_id' => $userId]);

        $coach = $stmt->fetch(PDO::FETCH_ASSOC);
        return $coach ?: null;
    }

    /**
     * Update a coach profile
     *
     * @param int $coachId The ID of the coach
     * @param array $data The data to update
     * @return bool True on success, false on failure
     */
    public static function update(int $coachId, array $data): bool
    {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("
            UPDATE coaches 
            SET phone = :phone, address = :address
            WHERE id = :id
        ");

        return $stmt->execute([
            ':id' => $coachId,
            ':phone' => $data['phone'] ?? null,
            ':address' => $data['address'] ?? null
        ]);
    }

    /**
     * Get all players belonging to the coach's team
     *
     * @param int $coachId The ID of the coach
     * @return array List of players
     */
    public static function getTeamPlayers(int $coachId): array
    {
        $db = Database::getInstance()->getConnection();
        // First find the team the coach belongs to
        $stmt = $db->prepare("SELECT team_id FROM coaches WHERE id = :coach_id");
        $stmt->execute([':coach_id' => $coachId]);
        $teamId = $stmt->fetchColumn();

        if (!$teamId) {
            return [];
        }

        $stmt = $db->prepare("
            SELECT p.*, u.first_name, u.last_name, u.email 
            FROM players p
            JOIN users u ON p.user_id = u.id
            WHERE p.team_id = :team_id
        ");
        $stmt->execute([':team_id' => $teamId]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
