<aside class="messages-sidebar">
    <h3>Error Log</h3>
    
    <?php if (empty($errors)): ?>
        <div class="empty-state">
            <p>Error messages will appear here when you submit the form.</p>
        </div>
    <?php endif; ?>
    
    <?php if (!empty($errors)): ?>
        <div class="error">
            <strong>Errors:</strong>
            <?php foreach ($errors as $error): ?>
                <p>• <?php echo htmlspecialchars($error); ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</aside>
