<form method="POST">
    <h2 class="step-title">Muscle Group</h2>
    <div class="form-group">
        <p>Select the muscle group(s) you want to improve:</p>
        <?php
            ViewHelper::renderCheckboxGroup(
                'muscles',
                $muscles,
                $formData['muscles'] ?? [],
                'updateMainTargetOptions()'
            );
        ?>
    </div>

    <?php
        ViewHelper::renderDynamicSelect(
            'main-target-section',
            'Which one is your main priority?',
            'main_muscle',
            'main_muscle_select'
        );
        ViewHelper::renderButtons(true, 'Next →'); 
    ?>
</form>

<script>
    // Update main target options based on selected muscles
    function updateMainTargetOptions() {
        const checkboxes = document.querySelectorAll('input[name="muscles[]"]:checked');
        const mainTargetSection = document.getElementById('main-target-section');
        const select = document.getElementById('main_muscle_select');
        const currentMain = "<?php echo $formData['main_muscle'] ?? ''; ?>";
        
        // Save current selection if any
        const currentSelection = select.value || currentMain;
        
        // Clear current options
        select.innerHTML = '';
        
        if (checkboxes.length > 1) {
            mainTargetSection.classList.remove('hidden');
            let foundSelected = false;
            
            checkboxes.forEach(cb => {
                const option = document.createElement('option');
                option.value = cb.value;
                option.text = cb.parentElement.textContent.trim();
                if (cb.value === currentSelection) {
                    option.selected = true;
                    foundSelected = true;
                }
                select.appendChild(option);
            });
            
            // If previously selected option is no longer available, select the first one
            if (!foundSelected && select.options.length > 0) {
                select.options[0].selected = true;
            }
        } else {
            mainTargetSection.classList.add('hidden');
        }
    }

    // Run on load
    document.addEventListener('DOMContentLoaded', updateMainTargetOptions);
</script>