<?php
        session_start();
        if(!isset($_SESSION['emp_id'])) header("Location: ../index.php");
        require_once("../funciones.php");
        $conexion = conectar("pufosa");
        // Comprobams que el usuario es presidente, y, si es asi, le damos acceso.
        switch(comprobarAcceso($conexion,$_SESSION['emp_id'])){
            case 2:
                break;
            case 1:
            case 0:
                header("Location: ../menu.php");
        }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Informe</title>
<!--BOOTSTRAP-->
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> 
<!---->
</head>
<body>
    <div class="container-fluid">

    <?php 
        imprimirBarra($conexion,$_SESSION['emp_id']);
        echo '<h2>Informe de departamentos</h2><hr>';

        $registros = mysqli_query($conexion,"SELECT departamento.Nombre, GrupoRegional, COUNT(empleado_ID) as cantidad, MIN(salario) as minimo, AVG(salario) as medio, MAX(salario) as maximo
                                            FROM empleados
                                            INNER JOIN departamento
                                            ON departamento.departamento_ID = empleados.Departamento_ID
                                            INNER JOIN ubicacion
                                            ON ubicacion.Ubicacion_ID = departamento.Ubicacion_ID
                                            GROUP BY empleados.Departamento_ID
                                            ORDER BY departamento.Nombre ASC");
        
        if(!empty($registros)){
            echo '
            <hr>
                <div class="container">
                    <input class="form-control" id="myInput" type="text" placeholder="Buscar..">
                    <br>
                </div>
            <hr>
            <table class="table table-striped table-hover">
                <thead>
                    <tr style="background-color: rgba(0,0,0,0.85);color:white;">
                        <th>Departamento</th>
                        <th>Ubicacion</th>
                        <th>Cantidad de empleados</th>
                        <th>Sueldo minimo</th>
                        <th>Sueldo medio</th>
                        <th>Sueldo maximo</th>
                    </tr>
                </thead>
            ';
        
            while($departamento = mysqli_fetch_array($registros)){
                echo '
                <tbody id="tablaDatos">
                    <tr>
                        <td>'.ucfirst($departamento['Nombre']).'</td>
                        <td>'.$departamento['GrupoRegional'].'</td>
                        <td>'.$departamento['cantidad'].'</td>
                        <td>'.$departamento['minimo'].'</td>
                        <td>'.$departamento['medio'].'</td>
                        <td>'.$departamento['maximo'].'</td>
                    </tr>
                </tbody>
                ';
            }
        echo '</table>';
        mysqli_close($conexion);
    }else{
        mysqli_close($conexion);
        header("Location: ../menu.php");
    }
        
    ?>
    </div>
    <script>
        $(document).ready(function(){
            $("#myInput").on("keyup", function() {
                var value = $(this).val().toLowerCase();
                    $("#tablaDatos tr").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });
        });
    </script> 
</body>
</html>