<?php

class FileUploader
{
    private $uploadDir;
    private $error = '';

    public function __construct()
    {
        $this->uploadDir = dirname(__DIR__, 2) . '/uploads';
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

    public function upload($file, $isTemp = false)
    {
        // Check if upload directory is ready
        if (!$this->ensureUploadDirectory()) {
            return false;
        }

        if (!isset($file['name']) || empty($file['name'])) {
            $this->error = "No file was uploaded.";
            return false;
        }

        // Validate MIME type
        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $mime_type = $finfo->file($file['tmp_name']);
        
        $allowed_mimes = [
            'image/jpeg' => 'jpg',
            'image/png' => 'png'
        ];

        if (!array_key_exists($mime_type, $allowed_mimes)) {
            $this->error = "Invalid file type. Only JPG and PNG images are allowed.";
            return false;
        }

        $file_ext = $allowed_mimes[$mime_type];
        
        if ($isTemp) {
            // Use system temp directory for temporary storage
            $tempDir = sys_get_temp_dir();
            $new_filename = uniqid('temp_profile_', true) . '.' . $file_ext;
            $destination = $tempDir . DIRECTORY_SEPARATOR . $new_filename;
        } else {
            $new_filename = uniqid('profile_', true) . '.' . $file_ext;
            $destination = $this->uploadDir . '/' . $new_filename;
        }

        if (move_uploaded_file($file['tmp_name'], $destination)) {
            $this->error = '';
            return $new_filename;
        }

        $this->error = "Failed to move uploaded file.";
        return false;
    }

    public function finalizeUpload($tempFilename)
    {
        if (strpos($tempFilename, 'temp_') !== 0) {
            return $tempFilename; // Already finalized or invalid
        }

        $tempDir = sys_get_temp_dir();
        $source = $tempDir . DIRECTORY_SEPARATOR . $tempFilename;
        
        // Create final filename
        $finalFilename = str_replace('temp_', '', $tempFilename);
        $destination = $this->uploadDir . '/' . $finalFilename;

        if (file_exists($source)) {
            if (rename($source, $destination)) {
                return $finalFilename;
            } else {
                $this->error = "Failed to finalize upload.";
                return false;
            }
        }
        
        $this->error = "Temporary file not found.";
        return false;
    }

    public function getTempFileContent($filename)
    {
        $tempDir = sys_get_temp_dir();
        $path = $tempDir . DIRECTORY_SEPARATOR . $filename;
        if (file_exists($path)) {
            return file_get_contents($path);
        }
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
