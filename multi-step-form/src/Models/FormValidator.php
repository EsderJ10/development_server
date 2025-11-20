<?php

class FormValidator
{
    private $errors = [];

    public function validateStep($step, $data, $files = [])
    {
        $this->errors = [];

        switch ($step) {
            case 1:
                $this->validateGender($data);
                break;
            case 2:
                $this->validateMuscle($data);
                break;
            case 3:
                $this->validatePerformance($data);
                break;
            case 4:
                $this->validatePlan($data);
                break;
            case 5:
                $this->validatePersonalInfo($data);
                $this->validateProfilePhoto($files, $data);
                break;
        }

        return empty($this->errors);
    }

    private function validateGender($data)
    {
        if (empty($data['gender'])) {
            $this->errors[] = "Please select your biological sex";
        }
    }

    private function validateMuscle($data)
    {
        if (empty($data['muscle'])) {
            $this->errors[] = "Please select at least one muscle group";
        }
    }

    private function validatePerformance($data)
    {
        if (empty($data['weight']) || empty($data['reps'])) {
            $this->errors[] = "Please complete both performance fields";
            return;
        }

        if (!is_numeric($data['weight']) || !is_numeric($data['reps'])) {
            $this->errors[] = "Weight and repetitions must be numeric values";
            return;
        }

        if ($data['weight'] <= 0 || $data['reps'] <= 0) {
            $this->errors[] = "Values must be greater than zero";
        }
    }

    private function validatePlan($data)
    {
        if (!isset($data['plan']) || $data['plan'] === '') {
            $this->errors[] = "Please select an improvement plan";
        }
    }

    private function validatePersonalInfo($data)
    {
        if (empty($data['name'])) {
            $this->errors[] = "Name is required";
        }

        if (empty($data['email'])) {
            $this->errors[] = "Email is required";
        } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $this->errors[] = "Email is not valid";
        }
    }

    private function validateProfilePhoto($files, $data = [])
    {
        if (empty($files['profile_pic']['name'])) {
            if (!empty($data['profile_pic_existing'])) {
                return;
            }
            $this->errors[] = "Please upload a profile photo";
            return;
        }

        $file = $files['profile_pic'];
        $allowed = ['jpg', 'jpeg', 'png'];
        $file_ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

        if (!in_array($file_ext, $allowed)) {
            $this->errors[] = "Only .jpg, .jpeg or .png files are allowed";
        }

        if ($file['size'] > 2000000) {
            $this->errors[] = "File is too large (maximum 2MB)";
        }

        if ($file['error'] !== 0) {
            $this->errors[] = "Error uploading file";
        }
    }

    public function getErrors()
    {
        return $this->errors;
    }

    public function addError($error)
    {
        $this->errors[] = $error;
    }
}
