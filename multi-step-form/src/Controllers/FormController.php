<?php

require_once __DIR__ . '/../Models/FormValidator.php';
require_once __DIR__ . '/../Models/PlanGenerator.php';
require_once __DIR__ . '/../Models/FileUploader.php';

class FormController
{
    private $validator;
    private $uploader;
    private $muscles = [
        'pectorals' => 'Pectorals',
        'biceps' => 'Biceps',
        'triceps' => 'Triceps',
        'glutes' => 'Glutes',
        'quadriceps' => 'Quadriceps',
        'abs' => 'Abdominals',
        'lats' => 'Lats',
        'shoulders' => 'Shoulders'
    ];

    public function __construct()
    {
        $this->validator = new FormValidator();
        $this->uploader = new FileUploader();
    }

    public function handleRequest()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['prev'])) {
                $this->handlePrevious();
            } elseif (isset($_POST['reset'])) {
                $this->handleReset();
            } elseif (isset($_POST['next'])) {
                $this->handleNext();
            }
        }
    }

    private function handlePrevious()
    {
        $_SESSION['step']--;
    }

    private function handleReset()
    {
        session_destroy();
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit;
    }

    private function handleNext()
    {
        // Prevent advancing past the final step (Step 7)
        if ($_SESSION['step'] >= 7) {
            return;
        }

        $isValid = $this->validator->validateStep(
            $_SESSION['step'],
            $_POST,
            $_FILES
        );

        if (!$isValid) {
            return;
        }

        $this->saveStepData($_SESSION['step']);
        
        // Check if there were errors during save (e.g., file upload)
        if (!empty($this->validator->getErrors())) {
            return;
        }
        
        $_SESSION['step']++;
    }

    private function saveStepData($step)
    {
        switch ($step) {
            case 1:
                $_SESSION['form_data']['gender'] = $_POST['gender'];
                break;
            case 2:
                $_SESSION['form_data']['muscle'] = $_POST['muscle'];
                break;
            case 3:
                $_SESSION['form_data']['weight'] = $_POST['weight'];
                $_SESSION['form_data']['reps'] = $_POST['reps'];
                break;
            case 4:
                $_SESSION['form_data']['plan'] = $_POST['plan'];
                break;
            case 5:
                $_SESSION['form_data']['name'] = htmlspecialchars($_POST['name']);
                $_SESSION['form_data']['email'] = htmlspecialchars($_POST['email']);
                
                if (!empty($_FILES['profile_pic']['name'])) {
                    // Upload as temporary file
                    $filename = $this->uploader->upload($_FILES['profile_pic'], true);
                    if ($filename) {
                        $_SESSION['form_data']['profile_pic'] = $filename;
                    } else {
                        // Add uploader error to validator errors
                        if ($this->uploader->hasError()) {
                            $this->validator->addError($this->uploader->getError());
                        }
                    }
                }
                break;
            case 6:
                // Finalize upload on confirmation
                if (isset($_SESSION['form_data']['profile_pic'])) {
                    $finalName = $this->uploader->finalizeUpload($_SESSION['form_data']['profile_pic']);
                    if ($finalName) {
                        $_SESSION['form_data']['profile_pic'] = $finalName;
                    }
                }
                break;
        }
    }

    public function getErrors()
    {
        return $this->validator->getErrors();
    }

    public function getCurrentStep()
    {
        return $_SESSION['step'];
    }

    public function getFormData()
    {
        return $_SESSION['form_data'];
    }

    public function getMuscles()
    {
        return $this->muscles;
    }

    public function generatePlans($muscle, $weight, $reps)
    {
        return PlanGenerator::generatePlans($muscle, $weight, $reps);
    }

    public function getSelectedPlan($planIndex)
    {
        $plans = $this->generatePlans(
            $_SESSION['form_data']['muscle'],
            $_SESSION['form_data']['weight'],
            $_SESSION['form_data']['reps']
        );
        return $plans[$planIndex] ?? null;
    }

    public function isFieldChecked($fieldName, $value)
    {
        return isset($_SESSION['form_data'][$fieldName]) && $_SESSION['form_data'][$fieldName] == $value;
    }

    public function getTempImage($filename)
    {
        return $this->uploader->getTempFileContent($filename);
    }

    public function getPlanSummary()
    {
        return [
            'plans' => $this->generatePlans(
                $_SESSION['form_data']['muscle'],
                $_SESSION['form_data']['weight'],
                $_SESSION['form_data']['reps']
            ),
            'selectedPlan' => $this->getSelectedPlan($_SESSION['form_data']['plan'])
        ];
    }
}