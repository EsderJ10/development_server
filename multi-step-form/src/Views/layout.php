<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Performance Improvement Plan - Step <?php echo $step; ?></title>
    <link rel="stylesheet" href="../../public/styles.css">
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Performance Improvement Plan</h1>
            <p>Step <?php echo $step; ?> of 6</p>
            <div class="progress-bar">
                <div class="progress-fill" style="width: <?php echo ($step / 6) * 100; ?>%"></div>
            </div>
        </div>
        
        <div class="main-wrapper">
            <div class="content">
                <?php include $viewFile; ?>
            </div>
            
            <?php include __DIR__ . '/components/error-sidebar.php'; ?>
        </div>
    </div>
    
    <script>
        // Card interactions
        document.querySelectorAll('.plan-card').forEach(card => {
            card.addEventListener('click', function() {
                document.querySelectorAll('.plan-card').forEach(c => c.classList.remove('selected'));
                this.classList.add('selected');
                this.querySelector('input[type="radio"]').checked = true;
            });
        });
        
        // Radio interactions
        document.querySelectorAll('.radio-option').forEach(option => {
            option.addEventListener('click', function() {
                this.querySelector('input[type="radio"]').checked = true;
            });
        });
    </script>
</body>
</html>
