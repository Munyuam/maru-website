<?php

namespace App\Controllers;

use App\Helpers\Session;
use App\Helpers\FileUpload;
use App\Models\Document;
use App\Config\Database;

class DocumentController
{
    public function upload()
    {
        // Validate CSRF
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $token = $_POST['csrf_token'] ?? '';
            if (!Session::validateCsrfToken($token)) {
                Session::setFlash('error', 'Invalid CSRF token.');
                header('Location: /profile');
                exit;
            }

            if (!isset($_FILES['document']) || !isset($_POST['document_type'])) {
                Session::setFlash('error', 'Please provide a document and its type.');
                header('Location: /profile');
                exit;
            }

            $documentType = $_POST['document_type'];
            
            $uploadDir = defined('UPLOAD_DIR') ? UPLOAD_DIR : __DIR__ . '/../../public/uploads/';
            $allowedExtensions = defined('ALLOWED_FILE_TYPES') ? ALLOWED_FILE_TYPES : ['jpg', 'jpeg', 'png', 'pdf'];
            $maxSize = defined('MAX_FILE_SIZE') ? MAX_FILE_SIZE : 5242880;

            try {
                $fileInfo = FileUpload::upload($_FILES['document'], $uploadDir, $allowedExtensions, $maxSize);
                
                if (!$fileInfo['success']) {
                    Session::setFlash('error', $fileInfo['error'] ?? 'File upload failed.');
                    header('Location: /player/profile');
                    exit;
                }

                $userId = Session::getUserId();
                if (!$userId) {
                    Session::setFlash('error', 'User not authenticated.');
                    header('Location: /login');
                    exit;
                }

                $data = [
                    'user_id' => $userId,
                    'document_type' => $documentType,
                    'file_path' => $fileInfo['file_path'],
                    'original_filename' => $fileInfo['file_name'],
                    'file_size' => $fileInfo['file_size'],
                    'mime_type' => $fileInfo['mime_type']
                ];
                
                if (Document::create($data)) {
                    Session::setFlash('success', 'Document uploaded successfully.');
                } else {
                    Session::setFlash('error', 'Database error while saving document record.');
                }
            } catch (\Exception $e) {
                Session::setFlash('error', 'An error occurred during upload.');
            }
            
            header('Location: /profile');
            exit;
        }
    }
}
