<?php 
    if (!isset($_COOKIE['count']))
    {
        $text = 'First time visiting this page.';
        $cookie = 1;
        setcookie('count', $cookie, time() + 720);
    } else {
        $cookie = ++$_COOKIE['count'];
        setcookie('count', $cookie, time() + 720);
        $text = "You have visited this page $cookie times.";
    }
?>

<html> 
    <head> 
        <title>Count Visits</title> 
    </head> 
    <body> 
        <?php echo $text; ?>
   </body> 
</html>
