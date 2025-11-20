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
            <p>Step <?php echo $step; ?> of <?php echo TOTAL_STEPS; ?></p>
            <div class="progress-bar">
                <div class="progress-fill" style="width: <?php echo ($step / TOTAL_STEPS) * 100; ?>%"></div>
            </div>
        </div>
        
        <div class="main-wrapper">
            <div class="content">
                <?php include $viewFile; ?>
            </div>
            
            <?php ViewHelper::renderErrorSidebar($errors ?? []); ?>
        </div>
    </div>
    
    <script src="../../public/script.js"></script>
</body>
</html>
