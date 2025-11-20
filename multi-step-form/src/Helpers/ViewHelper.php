<?php

/*
 * ViewHelper is a class that provides static methods to render various
 * components and elements in the multi-step form views.
 */

class ViewHelper
{
    /**
     * Renders a summary item row with label and value.
     * 
     * @param string $label The label for the item
     * @param string $value The value to display
     */
    public static function renderSummaryItem($label, $value)
    {
        $safeValue = is_string($value) ? $value : '';
        echo '<div class="summary-item">';
        echo '    <span class="summary-label">' . htmlspecialchars($label) . '</span>';
        echo '    <span class="summary-value">' . $safeValue . '</span>';
        echo '</div>';
    }

    /**
     * Renders a radio group.
     * 
     * @param string $name The name attribute for the radio inputs
     * @param array $options Associative array of value => label
     * @param string $selectedValue The currently selected value
     */
    public static function renderRadioGroup($name, $options, $selectedValue)
    {
        echo '<div class="radio-group">';
        foreach ($options as $value => $label) {
            $checked = ($selectedValue === $value) ? 'checked' : '';
            echo '<label class="radio-option ' . $checked . '">';
            echo '<input type="radio" name="' . htmlspecialchars($name) . '" value="' . htmlspecialchars($value) . '" ' . $checked . '>';
            echo '<span>' . htmlspecialchars($label) . '</span>';
            echo '</label>';
        }
        echo '</div>';
    }

    /**
     * Renders a checkbox group.
     * 
     * @param string $name The name attribute for the checkbox inputs
     * @param array $options Associative array of value => label
     * @param array $selectedValues Array of currently selected values
     */
    public static function renderCheckboxGroup($name, $options, $selectedValues)
    {
        echo '<div class="checkbox-group">';
        foreach ($options as $value => $label) {
            $isChecked = (is_array($selectedValues) && in_array($value, $selectedValues));
            $checkedStr = $isChecked ? 'checked' : '';
            
            echo '<label class="checkbox-option">';
            echo '<input type="checkbox" name="' . htmlspecialchars($name) . '[]" value="' . htmlspecialchars($value) . '" ' . $checkedStr . '>';
            echo htmlspecialchars($label);
            echo '</label>';
        }
        echo '</div>';
    }

    /**
     * Renders a standard input field.
     * 
     * @param string $label The label text
     * @param string $name The input name
     * @param string $value The current value
     * @param string $type Input type (text, number, email, etc.)
     * @param string $placeholder Placeholder text
     * @param bool $required Whether the field is required
     * @param array $attrs Additional attributes (min, max, step, etc.)
     * @param string $helperText Optional helper text below input
     */
    public static function renderInput($label, $name, $value, $type = 'text', $placeholder = '', $required = false, $attrs = [], $helperText = '')
    {
        $requiredAttr = $required ? 'required' : '';
        $attrString = '';
        foreach ($attrs as $k => $v) {
            $attrString .= ' ' . htmlspecialchars($k) . '="' . htmlspecialchars($v) . '"';
        }
        
        echo '<div class="form-group">';
        if ($label) {
            echo '<label>' . htmlspecialchars($label) . '</label>';
        }
        echo '<input type="' . htmlspecialchars($type) . '" name="' . htmlspecialchars($name) . '" value="' . htmlspecialchars($value) . '" placeholder="' . htmlspecialchars($placeholder) . '" ' . $requiredAttr . $attrString . '>';
        if ($helperText) {
            echo '<small class="form-helper">' . htmlspecialchars($helperText) . '</small>';
        }
        echo '</div>';
    }

    /**
     * Renders form navigation buttons.
     * 
     * @param bool $showPrevious Whether to show the previous button
     * @param string $nextText Text for the next button
     * @param string $prevText Text for the previous button
     */
    public static function renderButtons($showPrevious = true, $nextText = 'Next →', $prevText = '← Previous')
    {
        echo '<div class="buttons-container">';
        if ($showPrevious) {
            echo '<button type="submit" name="prev" class="btn-secondary">' . htmlspecialchars($prevText) . '</button>';
        }
        echo '<button type="submit" name="next" class="btn-primary">' . htmlspecialchars($nextText) . '</button>';
        echo '</div>';
    }

    /**
     * Renders a plan card.
     * 
     * @param array $plan The plan data
     * @param string $index The plan index/ID
     * @param string $selectedPlan The currently selected plan ID
     * @param array $muscles Array of muscle names for lookup
     */
    public static function renderPlanCard($plan, $index, $selectedPlan, $muscles)
    {
        $isSelected = ($selectedPlan == $index);
        $selectedClass = $isSelected ? 'selected' : '';
        $checked = $isSelected ? 'checked' : '';
        
        echo '<label class="plan-card ' . $selectedClass . '">';
        echo '<input type="radio" name="plan" value="' . htmlspecialchars($index) . '" class="visually-hidden" ' . $checked . '>';
        echo '<h3>' . htmlspecialchars($plan['name']) . '</h3>';
        echo '<p>' . htmlspecialchars($plan['description']) . '</p>';
        echo '<div class="plan-details">';
        echo '<div><strong>Target Muscle:</strong> ' . htmlspecialchars($muscles[$plan['muscle']]) . '</div>';
        echo '<div><strong>Target weight:</strong> ' . htmlspecialchars($plan['target_weight']) . ' kg</div>';
        echo '<div><strong>Reps:</strong> ' . htmlspecialchars($plan['target_reps']) . '</div>';
        echo '<div><strong>Timeline:</strong> ' . htmlspecialchars($plan['weeks']) . ' weeks</div>';
        echo '<div><strong>Intensity:</strong> ' . htmlspecialchars($plan['intensity']) . '</div>';
        echo '</div>';
        echo '</label>';
    }

    /**
     * Renders file upload input.
     * 
     * @param string $name Input name
     * @param string $currentFile Current file path/name
     * @param string $label Label text
     * @param string $accept Accepted file types
     */
    public static function renderFileUpload($name, $currentFile, $label, $accept = '.jpg,.jpeg,.png')
    {
        echo '<div class="form-group">';
        echo '<label>' . htmlspecialchars($label) . '</label>';
        
        if ($currentFile) {
            $displayFile = str_replace('temp_profile_', 'profile_', $currentFile);
            echo '<div class="current-file">';
            echo '<p>Current file: <strong>' . htmlspecialchars($displayFile) . '</strong></p>';
            echo '<input type="hidden" name="' . htmlspecialchars($name) . '_existing' . '" value="' . htmlspecialchars($currentFile) . '">';
            echo '</div>';
        }
        
        $required = $currentFile ? '' : 'required';
        echo '<input type="file" id="' . htmlspecialchars($name) . '" name="' . htmlspecialchars($name) . '" accept="' . htmlspecialchars($accept) . '" class="file-input-hidden" ' . $required . '>';
        
        $btnText = $currentFile ? 'Change Profile Photo' : 'Upload Profile Photo';
        echo '<label for="' . htmlspecialchars($name) . '" class="custom-file-upload">';
        echo $btnText;
        echo '</label>';
        echo '<small class="file-info" id="file-name-display">Maximum 5MB</small>';
        echo '</div>';
    }

    /**
     * Renders a hidden select container to be populated by JavaScript.
     * 
     * @param string $wrapperId The ID of the wrapper div (used by JS to show/hide)
     * @param string $label The text label above the select
     * @param string $selectName The name attribute of the select input
     * @param string $selectId The ID of the select input
     * @param string $selectedValue The currently selected value (optional)
     */
    public static function renderDynamicSelect($wrapperId, $label, $selectName, $selectId, $selectedValue = '')
    {
        echo '<div class="form-group dynamic-select-wrapper hidden" id="' . htmlspecialchars($wrapperId) . '">';
        echo '<p class="dynamic-select-label">' . htmlspecialchars($label) . '</p>';
        echo '<select name="' . htmlspecialchars($selectName) . '" id="' . htmlspecialchars($selectId) . '" class="form-control dynamic-select-input" data-initial-value="' . htmlspecialchars($selectedValue) . '">';
        echo '<!-- Options populated by JS -->';
        echo '</select>';
        echo '</div>';
    }

    /**
     * Renders the error sidebar.
     * 
     * @param array $errors Array of error messages
     */
    public static function renderErrorSidebar($errors)
    {
        echo '<aside class="messages-sidebar">';
        echo '<h3>Error Log</h3>';
        
        if (empty($errors)) {
            echo '<div class="empty-state">';
            echo '<p>Error messages will appear here when you submit the form.</p>';
            echo '</div>';
        } else {
            echo '<div class="error">';
            echo '<strong>Errors:</strong>';
            foreach ($errors as $error) {
                echo '<p>• ' . htmlspecialchars($error) . '</p>';
            }
            echo '</div>';
        }
        echo '</aside>';
    }

    /**
     * Renders the profile photo summary item.
     * 
     * @param string|null $src The image source URL or Base64 string
     */
    public static function renderProfileSummary($src)
    {
        if (!$src) {
            return;
        }
        
        echo '<div class="summary-item">';
        echo '    <span class="summary-label">Profile Photo</span>';
        echo '    <span class="summary-value">';
        echo '        <img src="' . $src . '" alt="Preview" style="width: 50px; height: 50px; object-fit: cover; border-radius: 50%;">';
        echo '    </span>';
        echo '</div>';
    }

    /**
     * Formats a list of muscle keys into a comma-separated string of names.
     * 
     * @param array $allMuscles Array of all available muscles (key => name)
     * @param array $selectedKeys Array of selected muscle keys
     * @return string
     */
    public static function formatMuscleList($allMuscles, $selectedKeys)
    {
        if (empty($selectedKeys) || !is_array($selectedKeys)) {
            return '';
        }
        
        $names = array_map(function($m) use ($allMuscles) { 
            return $allMuscles[$m] ?? $m; 
        }, $selectedKeys);

        return htmlspecialchars(implode(', ', $names));
    }

    /**
     * Formats weight and reps into a readable string.
     * 
     * @param mixed $weight
     * @param mixed $reps
     * @return string
     */
    public static function formatStats($weight, $reps)
    {
        return htmlspecialchars($weight) . 'kg / ' . htmlspecialchars($reps) . ' reps';
    }

    /**
     * Formats target weight and reps into a readable string.
     * 
     * @param mixed $weight
     * @param mixed $reps
     * @return string
     */
    public static function formatTargetStats($weight, $reps)
    {
        return htmlspecialchars($weight) . 'kg x ' . htmlspecialchars($reps) . ' reps';
    }

    /**
     * Generates the Base64 src for a temporary image.
     * 
     * @param object $controller The controller instance to retrieve temp image
     * @param string $filename The temporary filename
     * @return string|null The src string or null if not found
     */
    public static function getTempImageSrc($controller, $filename)
    {
        if (empty($filename)) {
            return null;
        }

        $imageData = $controller->getTempImage($filename);
        if ($imageData) {
            $mime = (strpos($filename, '.png') !== false) ? 'image/png' : 'image/jpeg';
            return 'data:' . $mime . ';base64,' . base64_encode($imageData);
        }

        return null;
    }

    /**
     * Generates the src for an uploaded image.
     * 
     * @param string $filename
     * @return string
     */
    public static function getUploadedImageSrc($filename)
    {
        return 'uploads/' . htmlspecialchars($filename);
    }
}