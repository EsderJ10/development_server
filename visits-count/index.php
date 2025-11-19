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
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --board-bg: #2d3436;
            --board-frame: #1e272e;
            --card-bg: #d63031;
            --card-text: #f5f6fa;
            --accent: #f9ca24;
            --floor-bg: #2f3542;
        }

        * { 
            margin: 0; 
            padding: 0; 
            box-sizing: border-box; 
        }

        body {
            background-color: var(--floor-bg);
            background-image: radial-gradient(circle at 50% 50%, #353b48 0%, #1e272e 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Bebas Neue', sans-serif;
            color: white;
            overflow: hidden;
        }

        .scoreboard-frame {
            background: var(--board-frame);
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0 20px 50px rgba(0,0,0,0.5), inset 0 2px 3px rgba(255,255,255,0.1);
            border: 4px solid #4b4b4b;
            transform-style: preserve-3d;
            perspective: 1000px;
            max-width: 500px;
            width: 90%;
            position: relative;
        }

        .screw {
            position: absolute;
            width: 12px; height: 12px;
            background: linear-gradient(45deg, #95a5a6, #7f8c8d);
            border-radius: 50%;
            box-shadow: inset 1px 1px 2px rgba(0,0,0,0.8);
        }
        .screw.tl { top: 10px; left: 10px; }
        .screw.tr { top: 10px; right: 10px; }
        .screw.bl { bottom: 10px; left: 10px; }
        .screw.br { bottom: 10px; right: 10px; }

        .board-header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid rgba(255,255,255,0.1);
            padding-bottom: 10px;
        }

        .board-title {
            font-size: 1.8rem;
            letter-spacing: 4px;
            color: rgba(255,255,255,0.4);
            text-transform: uppercase;
            text-shadow: 0 2px 2px rgba(0,0,0,0.5);
        }

        .score-container {
            display: flex;
            justify-content: center;
            margin: 30px 0;
            perspective: 1000px;
        }

        .flip-card {
            background-color: var(--card-bg);
            color: var(--card-text);
            font-size: 8rem;
            line-height: 1;
            padding: 20px 40px;
            border-radius: 10px;
            position: relative;
            box-shadow: 0 10px 20px rgba(0,0,0,0.4);
            text-shadow: 2px 2px 0px rgba(0,0,0,0.2);
            transform-origin: top center;
            transform: rotateX(0deg); 
            animation: swingIn 1s ease-out; 
            transition: transform 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        .flip-card::after {
            content: '';
            position: absolute;
            top: 50%; left: 0;
            width: 100%; height: 2px;
            background: rgba(0,0,0,0.2);
            box-shadow: 0 1px 0 rgba(255,255,255,0.1);
        }

        .rings {
            position: absolute;
            top: -15px; left: 0;
            width: 100%;
            display: flex; justify-content: center; gap: 60px;
        }
        
        .ring {
            width: 15px; height: 30px;
            border: 4px solid #bdc3c7;
            border-radius: 10px;
            background: transparent;
            z-index: -1;
        }

        .hole {
            position: absolute;
            top: 10px;
            width: 12px; height: 12px;
            background: #1e272e;
            border-radius: 50%;
            box-shadow: inset 0 1px 3px rgba(0,0,0,0.8);
        }
        .hole.left { left: 35px; }
        .hole.right { right: 35px; }

        .stats-panel {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            padding: 0 10px;
        }

        .stat-box {
            background: #222;
            border: 1px solid #444;
            padding: 15px;
            border-radius: 6px;
            text-align: center;
            position: relative;
        }

        .stat-label {
            display: block;
            font-size: 1rem;
            color: var(--accent);
            letter-spacing: 1px;
            margin-bottom: 5px;
            text-transform: uppercase;
        }

        .stat-value {
            font-size: 2.5rem;
            color: #fff;
            line-height: 1;
        }

        .message-display {
            margin-top: 25px;
            background: #000;
            border: 2px solid #333;
            padding: 10px;
            border-radius: 4px;
            text-align: center;
            color: var(--accent);
            font-family: 'Courier New', monospace;
            font-weight: bold;
            font-size: 0.9rem;
            letter-spacing: 1px;
            text-transform: uppercase;
            overflow: hidden;
            box-shadow: inset 0 0 10px rgba(0,0,0,0.9);
        }

        .blink { animation: blinker 1.5s linear infinite; }
        @keyframes blinker { 50% { opacity: 0.5; } }

        @keyframes swingIn {
            0% { transform: rotateX(-90deg); opacity: 0; }
            40% { transform: rotateX(20deg); opacity: 1; }
            60% { transform: rotateX(-10deg); }
            80% { transform: rotateX(5deg); }
            100% { transform: rotateX(0deg); }
        }

        /* Hover Effect */
        .score-container:hover .flip-card {
            transform: scale(1.05) rotateZ(2deg);
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="scoreboard-frame">
        <div class="screw tl"></div>
        <div class="screw tr"></div>
        <div class="screw bl"></div>
        <div class="screw br"></div>

        <div class="board-header">
            <h1 class="board-title">Total Visits</h1>
        </div>

        <div class="score-container">
            <div class="rings">
                <div class="ring"></div>
                <div class="ring"></div>
            </div>
            <div class="flip-card">
                <div class="hole left"></div>
                <div class="hole right"></div>
                <?php echo str_pad($visitCount, 2, '0', STR_PAD_LEFT); ?>
            </div>
        </div>

        <div class="stats-panel">
            <div class="stat-box">
                <span class="stat-label">Days Active</span>
                <span class="stat-value"><?php echo $daysSinceFirst; ?></span>
            </div>
            <div class="stat-box">
                <span class="stat-label">Avg / Day</span>
                <span class="stat-value"><?php echo $avgVisitsPerDay; ?></span>
            </div>
        </div>

        <div class="message-display">
            <?php if ($isFirstVisit): ?>
                <span class="blink">THIS IS YOUR FIRST VISIT!</span>
            <?php else: ?>
                <span>LAST VISIT: <?php echo isset($_COOKIE['last_visit']) ? date('M d, H:i', strtotime($_COOKIE['last_visit'])) : 'N/A'; ?></span>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>