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

    if(isset($empleadosData)&&!empty($empleadosData)){
        //Existen empleados que mostrar
        $output = '<ol class="list-group list-group-numbered">';
        
        foreach($empleadosData as $jefeClave => $jefeValor){
            $output .= "<li class='list-group-item'>";
            $output .= $jefeValor['apellidos'].", ".$jefeValor['nombre'];

            if(isset($jefeValor['empleados'])&&!empty($jefeValor['empleados'])){
                $empleados = $jefeValor['empleados'];
                $output .= getEmpleadosMarkup($empleados);

                /*foreach($jefeValor['empleados'] as $claveEmpleado => $valorEmpleado){
                    $output .= "<li>";
                    $output .= $valorEmpleado['apellidos'].", ".$valorEmpleado['nombre'];
                    $output .= "</li>";
                }

                $output .= '</ol>';
                */
            }

            $output .= "</li>";
        }

        $output .= '</ol>';

    }else{
        $output = '<p>No existen empleados que mostrar</p>';
    }

    return $output;
    /*return "<ol>
        <li>Jefe 1<ol>
            <li>Subornidado 1 1</li>
            <li>Subornidado 1 2</li>
            <li>Subornidado 1 3</li>
        </ol></li>
        <li>Jefe 2<ol>
            <li>Subornidado 2 1</li>
        </ol></li>
        <li>Jefe 3<ol>
            <li>Subornidado 3 1</li>
            <li>Subornidado 4 1</li>
        </ol></li>
    </ol>";*/
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
            0 => array(
                'nombre' => 'Roberto',
                'apellidos' => 'Sánchez',
                'empleados' => array()
            ),
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
    <title>Solución 2</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>
<body>
    <h1>Lista de empleados con subordinados</h1>
    <?php echo $empleadosMarkup; ?>
</body>
</html>