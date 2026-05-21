<?php
declare(strict_types=1);

namespace App\Models;

use App\Config\Database;
use PDO;

class Player
{
    /**
     * Create a new player profile
     */
    public static function create(int $userId, array $data): bool
    {
        $db = Database::getConnection();
        
        $sql = "INSERT INTO players (user_id, team_id, date_of_birth, gender, nationality, phone, position) 
                VALUES (:user_id, :team_id, :date_of_birth, :gender, :nationality, :phone, :position)";
                
        $stmt = $db->prepare($sql);
        
        return $stmt->execute([
            ':user_id' => $userId,
            ':team_id' => $data['team_id'] ?? null,
            ':date_of_birth' => $data['date_of_birth'],
            ':gender' => $data['gender'],
            ':nationality' => $data['nationality'],
            ':phone' => $data['phone'],
            ':position' => $data['position'] ?? null
        ]);
    }

    /**
     * Find a player by their user ID, including user details
     */
    public static function findByUserId(int $userId): ?array
    {
        $db = Database::getConnection();
        
        $sql = "SELECT p.*, u.email, u.first_name, u.last_name, u.is_active,
                       t.name as team_name, t.category as team_category
                FROM players p
                JOIN users u ON p.user_id = u.id
                LEFT JOIN teams t ON p.team_id = t.id
                WHERE p.user_id = :user_id";
                
        $stmt = $db->prepare($sql);
        $stmt->execute([':user_id' => $userId]);
        
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ?: null;
    }

    /**
     * Update player profile
     */
    public static function update(int $playerId, array $data): bool
    {
        $db = Database::getConnection();
        
        $fields = [];
        $params = [':id' => $playerId];
        
        $allowedFields = ['team_id', 'date_of_birth', 'gender', 'nationality', 'phone', 'position'];
        
        foreach ($allowedFields as $field) {
            if (array_key_exists($field, $data)) {
                $fields[] = "$field = :$field";
                $params[":$field"] = $data[$field];
            }
        }
        
        if (empty($fields)) {
            return false;
        }
        
        $sql = "UPDATE players SET " . implode(', ', $fields) . ", updated_at = CURRENT_TIMESTAMP WHERE id = :id";
        
        $stmt = $db->prepare($sql);
        return $stmt->execute($params);
    }

    /**
     * Get all players with optional filtering and pagination
     */
    public static function getAll(array $filters = [], int $page = 1): array
    {
        $db = Database::getConnection();
        $limit = 20;
        $offset = ($page - 1) * $limit;
        
        $where = [];
        $params = [];
        
        if (!empty($filters['team_id'])) {
            $where[] = "p.team_id = :team_id";
            $params[':team_id'] = $filters['team_id'];
        }
        
        if (!empty($filters['status'])) {
            if ($filters['status'] === 'unassigned') {
                $where[] = "p.team_id IS NULL";
            } elseif ($filters['status'] === 'assigned') {
                $where[] = "p.team_id IS NOT NULL";
            }
        }
        
        $whereClause = !empty($where) ? "WHERE " . implode(" AND ", $where) : "";
        
        $sql = "SELECT p.*, u.first_name, u.last_name, u.email, t.name as team_name
                FROM players p
                JOIN users u ON p.user_id = u.id
                LEFT JOIN teams t ON p.team_id = t.id
                $whereClause
                ORDER BY u.last_name ASC, u.first_name ASC
                LIMIT " . (int)$limit . " OFFSET " . (int)$offset;
                
        $stmt = $db->prepare($sql);
        $stmt->execute($params);
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Get all players in a specific team
     */
    public static function getByTeam(int $teamId): array
    {
        $db = Database::getConnection();
        
        $sql = "SELECT p.*, u.first_name, u.last_name, u.email
                FROM players p
                JOIN users u ON p.user_id = u.id
                WHERE p.team_id = :team_id
                ORDER BY u.last_name ASC, u.first_name ASC";
                
        $stmt = $db->prepare($sql);
        $stmt->execute([':team_id' => $teamId]);
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Get player registration status
     */
    public static function getRegistrationStatus(int $playerId): ?string
    {
        $db = Database::getConnection();
        
        $sql = "SELECT 
                    CASE 
                        WHEN team_id IS NULL THEN 'pending'
                        ELSE 'registered'
                    END as status
                FROM players
                WHERE id = :id";
                
        $stmt = $db->prepare($sql);
        $stmt->execute([':id' => $playerId]);
        
        $result = $stmt->fetchColumn();
        return $result !== false ? (string)$result : null;
    }

    /**
     * Get total count of players
     */
    public static function count(): int
    {
        $db = Database::getConnection();
        $stmt = $db->query("SELECT COUNT(*) FROM players");
        return (int) $stmt->fetchColumn();
    }

    /**
     * Get count of pending registrations
     */
    public static function countPending(): int
    {
        $db = Database::getConnection();
        $stmt = $db->query("SELECT COUNT(*) FROM players WHERE team_id IS NULL");
        return (int) $stmt->fetchColumn();
    }
}
