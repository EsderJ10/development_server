<form method="POST" enctype="multipart/form-data">
    <h2 class="step-title">Personal Information</h2>
    <div class="form-group">
        <label>Full Name:</label>
        <input type="text" name="name" 
            value="<?php echo isset($formData['name']) ? htmlspecialchars($formData['name']) : ''; ?>" 
            placeholder="Your name" required>
    </div>
    <div class="form-group">
        <label>Email:</label>
        <input type="email" name="email" 
            value="<?php echo isset($formData['email']) ? htmlspecialchars($formData['email']) : ''; ?>" 
            placeholder="you@email.com" required>
    </div>
    <div class="form-group">
        <label>Profile Photo (.jpg or .png):</label>
        <?php if (isset($formData['profile_pic'])): ?>
            <div class="current-file">
                <p>Current file: <strong><?php echo htmlspecialchars(str_replace('temp_profile_', 'profile_', $formData['profile_pic'])); ?></strong></p>
                <input type="hidden" name="profile_pic_existing" value="<?php echo htmlspecialchars($formData['profile_pic']); ?>">
            </div>
        <?php endif; ?>
        
        <input type="file" id="profile_pic" name="profile_pic" accept=".jpg,.jpeg,.png" class="file-input-hidden" <?php echo isset($formData['profile_pic']) ? '' : 'required'; ?>>
        <label for="profile_pic" class="custom-file-upload">
            <?php echo isset($formData['profile_pic']) ? 'Change Profile Photo' : 'Upload Profile Photo'; ?>
        </label>
        <small class="file-info" id="file-name-display">Maximum 5MB</small>
    </div>

    <script>
        // This script is only used to show the selected file name
        document.getElementById('profile_pic').addEventListener('change', function(e) {
            var fileName = e.target.files[0].name;
            document.getElementById('file-name-display').textContent = 'Selected: ' + fileName;
        });
    </script>

    <div class="buttons">
        <button type="submit" name="prev" class="btn-secondary">← Previous</button>
        <button type="submit" name="next" class="btn-primary">Finish</button>
    </div>
</form>
