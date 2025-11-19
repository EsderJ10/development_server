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
        <input type="file" id="profile_pic" name="profile_pic" accept=".jpg,.jpeg,.png" class="file-input-hidden" required>
        <label for="profile_pic" class="custom-file-upload">
            Upload Profile Photo
        </label>
        <small class="file-info">Maximum 5MB</small>
    </div>

    <div class="buttons">
        <button type="submit" name="prev" class="btn-secondary">← Previous</button>
        <button type="submit" name="next" class="btn-primary">Finish</button>
    </div>
</form>
