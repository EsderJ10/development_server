<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tablero</title>
</head>
<body>
    <h1>Formulario DWES</h1>

    <form action="<?php echo($_SERVER['PHP_SELF']); ?>" method="get">
        <input type="text" name="col">
        <br>
        <input type="text" name="row">
        <br>
        <input type="submit">
    </form>
    
</body>
</html>