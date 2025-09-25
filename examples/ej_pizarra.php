<?php
//Inicialización entorno
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

//Lógica de negocio
//Definición o carga de funciones

function dump($var) {
    echo '<pre>'. print_r($var, 1) . '</pre>';
}

function getEmpleadosMarkup($empleadosData){
    $output = '';

    if (isset($empleadosData) && !empty($empleadosData)) {
        $output = '<ol>';

        foreach ($empleadosData as $empleado) {
            $nombre = isset($empleado['nombre']) ? $empleado['nombre'] : '';
            $apellidos = isset($empleado['apellidos']) ? $empleado['apellidos'] : '';

            $output .= "<li>{$apellidos}, {$nombre}";

            if (isset($empleado['empleados']) && !empty($empleado['empleados'])) {
                $subordinados = $empleado['empleados'];

                // Conversión a lista para evitar errores
                if (isset($subordinados['nombre'])) {
                    $subordinados = array($subordinados);
                }


                $output .= getEmpleadosMarkup($subordinados);
            }

            $output .= "</li>";
        }

        $output .= '</ol>';
    } else {
        $output = '<p>No existen empleados que mostrar</p>';
    }

    return $output;
}

//Cargamos datos
$empleados = array(
    0 => array(
        'nombre' => 'Pedro',
        'apellidos' => 'España Fernández',
        'empleados' => array(
            0 => array(
                'nombre' => 'Juan',
                'apellidos' => 'Hernández',
                'empleados' => array()
            ),
            1 => array(
                'nombre' => 'María',
                'apellidos' => 'Fernández',

            ),
        )
    ),
    1 => array(
        'nombre' => 'Lorena',
        'apellidos' => 'Hidalgo',
        'empleados' => array(
            'nombre' => 'Roberto',
            'apellidos' => 'Sánchez',
            'empleados' => array(
            	'nombre' => 'John',
                'apellidos' => 'Doe',
            )
        ),
    ),
    2 => array(
        'nombre' => 'Nicolás',
        'apellidos' => 'Pérez',
    )
);

$empleadosMarkup = getEmpleadosMarkup($empleados);

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Solución 1</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>
<body>
    <h1>Lista de empleados con subordinados</h1>
    <?php echo $empleadosMarkup; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>