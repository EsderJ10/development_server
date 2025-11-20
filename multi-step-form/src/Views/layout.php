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

    <div class="github-tab">
        <a href="https://github.com/EsderJ10" target="_blank">
            <span>Profile</span>
            <svg viewBox="0 0 24 24" width="16" height="16" stroke="currentColor" stroke-width="2" fill="none">
                <path d="M9 19c-5 1.5-5-2.5-7-3m14 6v-3.87a3.37 3.37 0 0 0-.94-2.61c3.14-.35 6.44-1.54 6.44-7A5.44 5.44 0 0 0 20 4.77 5.07 5.07 0 0 0 19.91 1S18.73.65 16 2.48a13.38 13.38 0 0 0-7 0C6.27.65 5.09 1 5.09 1A5.07 5.07 0 0 0 5 4.77a5.44 5.44 0 0 0-1.5 3.78c0 5.42 3.3 6.61 6.44 7A3.37 3.37 0 0 0 9 18.13V22"></path>
            </svg>
        </a>
    </div>
    
    <script src="../../public/script.js"></script>
</body>
</html>
