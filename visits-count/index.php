<?php
if (!isset($_COOKIE['visitCount'])) {
    $visitCount = 1;
    $firstVisit = date('Y-m-d H:i:s');
    // Set cookies for 30 days
    setcookie('visitCount', $visitCount, time() + (30 * 24 * 60 * 60));
    setcookie('firstVisit', $firstVisit, time() + (30 * 24 * 60 * 60));
    setcookie('last_visit', $firstVisit, time() + (30 * 24 * 60 * 60));
    $isFirstVisit = true;
} else {
    $visitCount = (int)$_COOKIE['visitCount'] + 1;
    $firstVisit = $_COOKIE['firstVisit'] ?? date('Y-m-d H:i:s');
    $last_visit = $_COOKIE['last_visit'] ?? $firstVisit;
    $isFirstVisit = false;
    
    // Update cookies
    setcookie('visitCount', $visitCount, time() + (30 * 24 * 60 * 60));
    setcookie('last_visit', date('Y-m-d H:i:s'), time() + (30 * 24 * 60 * 60));
}
// Calculate visit stats
$timestamp = time();
$daysSinceFirst = intdiv((int)$timestamp - strtotime($firstVisit), 86400);
$avgVisitsPerDay = $daysSinceFirst > 0 ? round($visitCount / ($daysSinceFirst + 1), 2) : $visitCount;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visitor Tracker</title>
</head>
<body>
    <div>
        <div></div>
        <div></div>
        <div></div>
        <div></div>
        <div>
            <h1>Total Visits</h1>
        </div>
        <div>
            <div>
                <div></div>
                <div></div>
            </div>
            <div>
                <div></div>
                <div></div>
                <?php echo str_pad($visitCount, 2, '0', STR_PAD_LEFT); ?>
            </div>
        </div>
        <div>
            <div>
                <span>Days Active</span>
                <span><?php echo $daysSinceFirst; ?></span>
            </div>
            <div>
                <span>Avg / Day</span>
                <span><?php echo $avgVisitsPerDay; ?></span>
            </div>
        </div>
        <div>
            <?php if ($isFirstVisit): ?>
                <span>THIS IS YOUR FIRST VISIT!</span>
            <?php else: ?>
                <span>LAST MATCH: <?php echo isset($_COOKIE['last_visit']) ? date('M d, H:i', strtotime($_COOKIE['last_visit'])) : 'N/A'; ?></span>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>