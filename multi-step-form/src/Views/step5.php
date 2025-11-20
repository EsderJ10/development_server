<form method="POST" enctype="multipart/form-data">
    <h2 class="step-title">Personal Information</h2>
    <?php
        ViewHelper::renderInput(
            'Full Name:',
            'name',
            $formData['name'] ?? '',
            'text',
            'Your name',
            true
        );

        ViewHelper::renderInput(
            'Email:',
            'email',
            $formData['email'] ?? '',
            'email',
            'you@email.com',
            true
        );

        ViewHelper::renderFileUpload(
            'profile_pic',
            $formData['profile_pic'] ?? null,
            'Profile Photo (.jpg or .png):'
        );
    ?>

    <script>
        // This script is only used to show the selected file name
        document.getElementById('profile_pic').addEventListener('change', function(e) {
            var fileName = e.target.files[0].name;
            document.getElementById('file-name-display').textContent = 'Selected: ' + fileName;
        });
    </script>

    <?php ViewHelper::renderButtons(true, 'Finish'); ?>
</form>
