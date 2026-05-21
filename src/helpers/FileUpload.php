<?php

namespace App\Helpers;

class FileUpload {
    public static function upload(array $file, string $directory, array $allowedExtensions, int $maxSize): array {
        if ($file['error'] !== UPLOAD_ERR_OK) {
            return ['success' => false, 'error' => 'File upload error code: ' . $file['error']];
        }

        if ($file['size'] > $maxSize) {
            return ['success' => false, 'error' => 'File exceeds maximum allowed size.'];
        }

        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mimeType = finfo_file($finfo, $file['tmp_name']);
        finfo_close($finfo);

        $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

        $allowedMimes = [
            'jpg' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'png' => 'image/png',
            'pdf' => 'application/pdf'
        ];

        if (!in_array($extension, $allowedExtensions)) {
             return ['success' => false, 'error' => 'Invalid file type.'];
        }

        if (!isset($allowedMimes[$extension]) || $allowedMimes[$extension] !== $mimeType) {
            return ['success' => false, 'error' => 'File content does not match the declared type.'];
        }

        if (!is_dir($directory)) {
            mkdir($directory, 0755, true);
        }

        $uniqueName = bin2hex(random_bytes(16)) . '.' . $extension;
        $destination = $directory . DIRECTORY_SEPARATOR . $uniqueName;

        if (move_uploaded_file($file['tmp_name'], $destination)) {
            return [
                'success' => true,
                'file_name' => $file['name'],
                'file_path' => $uniqueName,
                'file_size' => $file['size'],
                'mime_type' => $mimeType
            ];
        }

        return ['success' => false, 'error' => 'Failed to move uploaded file.'];
    }

    public static function delete(string $filePath): bool {
        if (file_exists($filePath)) {
            return unlink($filePath);
        }
        return false;
    }
}
