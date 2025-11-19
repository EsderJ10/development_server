<?php

class FileUploader
{
    private $uploadDir = 'uploads';
    private $error = '';

    public function __construct()
    {
        $this->ensureUploadDirectory();
    }

    private function ensureUploadDirectory()
    {
        if (!file_exists($this->uploadDir)) {
            if (!@mkdir($this->uploadDir, 0755, true)) {
                $this->error = "Unable to create uploads directory. Please ensure the application has write permissions.";
                return false;
            }
        }

        if (!is_writable($this->uploadDir)) {
            $this->error = "Uploads directory exists but is not writable. Please check directory permissions.";
            return false;
        }

        return true;
    }

    public function upload($file)
    {
        // Check if upload directory is ready
        if (!$this->ensureUploadDirectory()) {
            return false;
        }

        if (!isset($file['name']) || empty($file['name'])) {
            $this->error = "No file was uploaded.";
            return false;
        }

        $file_ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $new_filename = uniqid('profile_', true) . '.' . $file_ext;
        $destination = $this->uploadDir . '/' . $new_filename;

        if (move_uploaded_file($file['tmp_name'], $destination)) {
            $this->error = '';
            return $new_filename;
        }

        $this->error = "Failed to move uploaded file. Please check directory permissions.";
        return false;
    }

    public function getUploadDir()
    {
        return $this->uploadDir;
    }

    public function getError()
    {
        return $this->error;
    }

    public function hasError()
    {
        return !empty($this->error);
    }
}
