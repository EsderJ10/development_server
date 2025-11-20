document.addEventListener('DOMContentLoaded', function() {
    // --- Global Interactions ---

    // Radio Group Styling
    const radioOptions = document.querySelectorAll('.radio-option');
    radioOptions.forEach(option => {
        option.addEventListener('click', function(e) {
            // Find the radio input within this option
            const radioInput = this.querySelector('input[type="radio"]');
            
            // If the click wasn't on the input itself, trigger it
            if (e.target !== radioInput) {
                radioInput.checked = true;
                // Trigger change event manually if needed
                radioInput.dispatchEvent(new Event('change', { bubbles: true }));
            }

            // Update visual state
            // Find the parent group to clear other selections
            const group = this.closest('.radio-group');
            if (group) {
                group.querySelectorAll('.radio-option').forEach(el => el.classList.remove('checked'));
                this.classList.add('checked');
            }
        });
    });

    // Plan Card Selection
    const planCards = document.querySelectorAll('.plan-card');
    planCards.forEach(card => {
        card.addEventListener('click', function(e) {
            const radioInput = this.querySelector('input[type="radio"]');
            
             if (e.target !== radioInput) {
                radioInput.checked = true;
                radioInput.dispatchEvent(new Event('change', { bubbles: true }));
            }

            document.querySelectorAll('.plan-card').forEach(c => c.classList.remove('selected'));
            this.classList.add('selected');
        });
    });

    // --- Step 2: Muscle Selection ---
    
    const muscleCheckboxes = document.querySelectorAll('input[name="muscles[]"]');
    if (muscleCheckboxes.length > 0) {
        // Initial run
        updateMainTargetOptions();

        // Add listeners
        muscleCheckboxes.forEach(cb => {
            cb.addEventListener('change', updateMainTargetOptions);
        });
    }

    function updateMainTargetOptions() {
        const checkboxes = document.querySelectorAll('input[name="muscles[]"]:checked');
        const mainTargetSection = document.getElementById('main-target-section');
        const select = document.getElementById('main_muscle_select');
        
        // If these elements don't exist, we are not on step 2
        if (!mainTargetSection || !select) return;

        // Get initial value from data attribute
        const initialValue = select.dataset.initialValue || '';
        const currentSelection = select.value || initialValue;
        
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

    // --- Step 5: File Upload ---
    const fileInput = document.getElementById('profile_pic');
    if (fileInput) {
        fileInput.addEventListener('change', function(e) {
            if (e.target.files && e.target.files[0]) {
                var fileName = e.target.files[0].name;
                const display = document.getElementById('file-name-display');
                if (display) {
                    display.textContent = 'Selected: ' + fileName;
                }
            }
        });
    }
});
