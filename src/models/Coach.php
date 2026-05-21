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
        $db = Database::getConnection();
        $stmt = $db->prepare("
            INSERT INTO coaches (user_id, team_id, phone, address, date_of_birth, qualification, years_experience, coaching_specialty)
            VALUES (:user_id, :team_id, :phone, :address, :date_of_birth, :qualification, :years_experience, :coaching_specialty)
        ");

        return $stmt->execute([
            ':user_id' => $userId,
            ':team_id' => $data['team_id'] ?? null,
            ':phone' => $data['phone'] ?? null,
            ':address' => $data['address'] ?? null,
            ':date_of_birth' => $data['date_of_birth'] ?? null,
            ':qualification' => $data['qualification'] ?? null,
            ':years_experience' => $data['years_experience'] ?? null,
            ':coaching_specialty' => $data['coaching_specialty'] ?? null
        ]);
    }

    /**
     * Find a coach by their ID
     *
     * @param int $id The coach ID
     * @return array|null The coach data or null if not found
     */
    public static function findById(int $id): ?array
    {
        $db = Database::getConnection();
        $stmt = $db->prepare("
            SELECT c.*, u.first_name, u.last_name, u.email, t.name as team_name
            FROM coaches c
            JOIN users u ON c.user_id = u.id
            LEFT JOIN teams t ON c.team_id = t.id
            WHERE c.id = :id
        ");
        $stmt->execute([':id' => $id]);
        $coach = $stmt->fetch(PDO::FETCH_ASSOC);
        return $coach ?: null;
    }

    /**
     * Find a coach by their user ID
     *
     * @param int $userId The user ID
     * @return array|null The coach data or null if not found
     */
    public static function findByUserId(int $userId): ?array
    {
        $db = Database::getConnection();
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
        $db = Database::getConnection();
        
        $allowedFields = ['phone', 'address', 'date_of_birth', 'qualification', 'years_experience', 'coaching_specialty', 'team_id'];
        $updates = [];
        $params = [':id' => $coachId];
        
        foreach ($allowedFields as $field) {
            if (array_key_exists($field, $data)) {
                $updates[] = "$field = :$field";
                $params[":$field"] = $data[$field];
            }
        }
        
        if (empty($updates)) {
            return false;
        }
        
        $sql = "UPDATE coaches SET " . implode(', ', $updates) . " WHERE id = :id";
        $stmt = $db->prepare($sql);
        return $stmt->execute($params);
    }

    /**
     * Get all coaches
     *
     * @return array List of all coaches with user details
     */
    public static function all(): array
    {
        $db = Database::getConnection();
        $stmt = $db->query("
            SELECT c.*, u.first_name, u.last_name, u.email, u.avatar, t.name as team_name, c.registration_status
            FROM coaches c
            JOIN users u ON c.user_id = u.id
            LEFT JOIN teams t ON c.team_id = t.id
            ORDER BY u.last_name ASC, u.first_name ASC
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Get total count of coaches
     *
     * @return int
     */
    public static function count(): int
    {
        $db = Database::getConnection();
        $stmt = $db->query("SELECT COUNT(*) FROM coaches");
        return (int) $stmt->fetchColumn();
    }

    /**
     * Get all players belonging to the coach's team
     *
     * @param int $coachId The ID of the coach
     * @return array List of players
     */
    public static function getTeamPlayers(int $coachId): array
    {
        $db = Database::getConnection();
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
