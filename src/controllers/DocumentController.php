<?php

namespace App\Controllers;

use App\Helpers\Session;
use App\Helpers\FileUpload;
use App\Models\Document;
use App\Config\app;

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
            
            // Assuming ALLOWED_FILE_TYPES and MAX_FILE_SIZE are global constants defined in config
            $uploadDir = defined('UPLOAD_DIR') ? UPLOAD_DIR : __DIR__ . '/../../../public/uploads/';
            $allowedTypes = defined('ALLOWED_FILE_TYPES') ? ALLOWED_FILE_TYPES : ['application/pdf', 'image/jpeg', 'image/png'];
            $maxSize = defined('MAX_FILE_SIZE') ? MAX_FILE_SIZE : 5242880;

            try {
                $fileInfo = FileUpload::upload($_FILES['document'], $uploadDir, $allowedTypes, $maxSize);
                
                if ($fileInfo) {
                    $userId = Session::getUser()['id'] ?? null;
                    if (!$userId) {
                        Session::setFlash('error', 'User not authenticated.');
                        header('Location: /login');
                        exit;
                    }

                    $data = [
                        'user_id' => $userId,
                        'document_type' => $documentType,
                        'file_path' => $fileInfo['path'] ?? $fileInfo['filename'] ?? '',
                        'original_filename' => $_FILES['document']['name'],
                        'file_size' => $_FILES['document']['size'],
                        'mime_type' => $_FILES['document']['type']
                    ];
                    
                    if (Document::create($data)) {
                        Session::setFlash('success', 'Document uploaded successfully.');
                    } else {
                        Session::setFlash('error', 'Database error while saving document record.');
                    }
                }
            } catch (\Exception $e) {
                Session::setFlash('error', $e->getMessage());
            }
            
            header('Location: /profile');
            exit;
        }
    }
}
