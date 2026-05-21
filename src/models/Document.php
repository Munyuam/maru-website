<?php

namespace App\Models;

use App\Config\Database;
use PDO;

class Document
{
    public static function create(array $data): bool
    {
        $db = Database::getConnection();
        $stmt = $db->prepare("INSERT INTO documents (user_id, document_type, file_path, original_filename, file_size, mime_type, verification_status, uploaded_at) VALUES (:user_id, :document_type, :file_path, :original_filename, :file_size, :mime_type, 'pending', NOW())");
        
        return $stmt->execute([
            'user_id' => $data['user_id'],
            'document_type' => $data['document_type'],
            'file_path' => $data['file_path'],
            'original_filename' => $data['original_filename'] ?? null,
            'file_size' => $data['file_size'] ?? null,
            'mime_type' => $data['mime_type'] ?? null
        ]);
    }

    public static function findByUserId(int $userId): array
    {
        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT * FROM documents WHERE user_id = :user_id ORDER BY uploaded_at DESC");
        $stmt->execute(['user_id' => $userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function findById(int $id): ?array
    {
        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT * FROM documents WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ?: null;
    }

    public static function getPending(): array
    {
        $db = Database::getConnection();
        $stmt = $db->query("SELECT d.*, u.first_name, u.last_name FROM documents d JOIN users u ON d.user_id = u.id WHERE d.verification_status = 'pending' ORDER BY d.uploaded_at ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function updateStatus(int $id, string $status, ?int $verifiedBy = null, ?string $notes = null): bool
    {
        $db = Database::getConnection();
        $stmt = $db->prepare("UPDATE documents SET verification_status = :status, verified_by = :verified_by, verification_notes = :notes, verified_at = NOW() WHERE id = :id");
        return $stmt->execute([
            'status' => $status,
            'verified_by' => $verifiedBy,
            'notes' => $notes,
            'id' => $id
        ]);
    }
}
