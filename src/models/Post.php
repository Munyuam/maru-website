<?php
declare(strict_types=1);

namespace App\Models;

use App\Config\Database;
use PDO;

class Post
{
    public static function create(array $data): int
    {
        $db = Database::getConnection();
        $stmt = $db->prepare("
            INSERT INTO posts (title, excerpt, body, image, author_id, is_published, published_at)
            VALUES (:title, :excerpt, :body, :image, :author_id, :is_published, :published_at)
        ");
        $stmt->execute([
            'title' => $data['title'],
            'excerpt' => $data['excerpt'] ?? null,
            'body' => $data['body'],
            'image' => $data['image'] ?? null,
            'author_id' => $data['author_id'],
            'is_published' => $data['is_published'] ?? 0,
            'published_at' => $data['published_at'] ?? null,
        ]);
        return (int)$db->lastInsertId();
    }

    public static function findAll(): array
    {
        $db = Database::getConnection();
        $stmt = $db->query("
            SELECT p.*, u.first_name, u.last_name
            FROM posts p
            JOIN users u ON p.author_id = u.id
            ORDER BY p.created_at DESC
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function findPublished(): array
    {
        $db = Database::getConnection();
        $stmt = $db->query("
            SELECT p.*, u.first_name, u.last_name
            FROM posts p
            JOIN users u ON p.author_id = u.id
            WHERE p.is_published = 1
            ORDER BY p.published_at DESC
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function findPublishedExcept(int $excludeId): array
    {
        $db = Database::getConnection();
        $stmt = $db->prepare("
            SELECT p.*, u.first_name, u.last_name
            FROM posts p
            JOIN users u ON p.author_id = u.id
            WHERE p.is_published = 1 AND p.id != :id
            ORDER BY p.published_at DESC
            LIMIT 3
        ");
        $stmt->execute(['id' => $excludeId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function findById(int $id): ?array
    {
        $db = Database::getConnection();
        $stmt = $db->prepare("
            SELECT p.*, u.first_name, u.last_name
            FROM posts p
            JOIN users u ON p.author_id = u.id
            WHERE p.id = :id
        ");
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ?: null;
    }

    public static function update(int $id, array $data): bool
    {
        $db = Database::getConnection();
        $fields = [];
        $params = ['id' => $id];
        foreach (['title', 'excerpt', 'body', 'image', 'is_published', 'published_at'] as $col) {
            if (array_key_exists($col, $data)) {
                $fields[] = "$col = :$col";
                $params[$col] = $data[$col];
            }
        }
        if (empty($fields)) return false;
        $sql = "UPDATE posts SET " . implode(', ', $fields) . " WHERE id = :id";
        $stmt = $db->prepare($sql);
        return $stmt->execute($params);
    }

    public static function delete(int $id): bool
    {
        $db = Database::getConnection();
        $stmt = $db->prepare("DELETE FROM posts WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }
}
