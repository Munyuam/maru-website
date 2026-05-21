<?php
declare(strict_types=1);

namespace App\Models;

use App\Config\Database;
use PDO;

/**
 * Class User
 * Handles database operations for the users table.
 */
class User
{
    /**
     * Find a user by their email address.
     *
     * @param string $email The email address to search for.
     * @return array|null The user record as an associative array, or null if not found.
     */
    public static function findByEmail(string $email): ?array
    {
        $db = Database::getConnection();
        $stmt = $db->prepare('SELECT * FROM users WHERE email = :email LIMIT 1');
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        return $user !== false ? $user : null;
    }

    /**
     * Find a user by their ID.
     *
     * @param int $id The user ID to search for.
     * @return array|null The user record as an associative array, or null if not found.
     */
    public static function findById(int $id): ?array
    {
        $db = Database::getConnection();
        $stmt = $db->prepare('SELECT * FROM users WHERE id = :id LIMIT 1');
        $stmt->execute(['id' => $id]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        return $user !== false ? $user : null;
    }

    /**
     * Create a new user record.
     *
     * @param array $data The user data. Expected to contain 'password' among other fields.
     * @return int The ID of the newly created user.
     */
    public static function create(array $data): int
    {
        $db = Database::getConnection();
        
        if (isset($data['password'])) {
            $data['password'] = password_hash($data['password'], PASSWORD_BCRYPT);
        }
        
        $columns = implode(', ', array_keys($data));
        $placeholders = ':' . implode(', :', array_keys($data));
        
        $sql = "INSERT INTO users ($columns) VALUES ($placeholders)";
        $stmt = $db->prepare($sql);
        $stmt->execute($data);
        
        return (int) $db->lastInsertId();
    }

    /**
     * Update a user's profile details.
     *
     * @param int $id The user ID.
     * @param array $data The fields to update (first_name, last_name, email, phone, avatar).
     * @return bool True on success, false on failure.
     */
    public static function update(int $id, array $data): bool
    {
        $db = Database::getConnection();
        
        $allowedFields = ['first_name', 'last_name', 'email', 'phone', 'avatar'];
        $updates = [];
        $params = ['id' => $id];
        
        foreach ($allowedFields as $field) {
            if (isset($data[$field])) {
                $updates[] = "$field = :$field";
                $params[$field] = $data[$field];
            }
        }
        
        if (empty($updates)) {
            return false;
        }
        
        $sql = 'UPDATE users SET ' . implode(', ', $updates) . ' WHERE id = :id';
        $stmt = $db->prepare($sql);
        return $stmt->execute($params);
    }

    /**
     * Update a user's password.
     *
     * @param int $id The user ID.
     * @param string $newPassword The new plain-text password to be hashed and saved.
     * @return bool True on success, false on failure.
     */
    public static function updatePassword(int $id, string $newPassword): bool
    {
        $db = Database::getConnection();
        
        $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);
        
        $stmt = $db->prepare('UPDATE users SET password = :password WHERE id = :id');
        return $stmt->execute([
            'password' => $hashedPassword,
            'id' => $id
        ]);
    }
}
