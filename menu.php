<?php
    session_start();
    $conexion = mysqli_connect("localhost","root","","pufosa") or
        die("Problemas con la conexion.");
    
    require_once("funciones.php");

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>PUFO's app</title>
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
        /**
         * Si hay una sesion iniciada, cogerá los datos de esa sesion.
         */
        if(isset($_SESSION['emp_id'])){
            $user_valido = true;
            $registros = mysqli_query($conexion,"select * from empleados where empleado_ID = '".$_SESSION['emp_id']."'") or
                die("Problemas con el select: ".mysqli_error($conexion));
            $user = mysqli_fetch_array($registros);
            $trabajo = mysqli_query($conexion,"select * 
                                                from trabajos tra, empleados emp
                                                where tra.Trabajo_ID = emp.trabajo_ID and emp.empleado_ID = '".$_SESSION['emp_id']."'")
                or die("Problemas con el select.".mysqli_error($conexion));
            $trabajo = mysqli_fetch_array($trabajo)['Funcion'];
        /**
         * Si no existe una sesion, comprueba que el empleado ingresado existe y despues crea una sesion y te muestra todas las opciones.
         */
        }else if(isset($_REQUEST['user_id'])){
            
            $registros = mysqli_query($conexion,"select * from empleados where empleado_ID = '".$_REQUEST['user_id']."'")
                or die("Problemas con el select: ".mysqli_error($conexion));
            
            if($user = mysqli_fetch_array($registros)){
                $user_valido = true;
                $_SESSION['emp_id'] = $_REQUEST['user_id'];
                $trabajo = mysqli_query($conexion,"select Funcion 
                                                    from trabajos tra, empleados emp
                                                    where tra.Trabajo_ID = emp.trabajo_ID and emp.empleado_ID = '".$_SESSION['emp_id']."'")
                    or die("Problemas con el select.".mysqli_error($conexion));
                $trabajo = mysqli_fetch_array($trabajo)['Funcion'];

            }else{
                $user_valido = false;
            }
        }else{
            header("Location: index.php");
        }

        /**
         * Si el ususario ingresado es valido, imprimirá las diferentes opciones que tiene segun su rol.
         */
        if($user_valido)
        {
            echo "<h2>Bienvenido/a &nbsp;".$user['Nombre']."&nbsp;".$user['Apellido']."&nbsp;".$user['Inicial_del_segundo_apellido']."</h2><br>";
            if($trabajo == 'PRESIDENT' || $trabajo == 'Manager'){
                $_SESSION['admin'] = true;
                header("Location: tablas/clientes.php");
            }else{
                $_SESSION['admin'] = false;
                header("Location: tablas/clientes.php");
            }
        }else{
            header("Location: index.php");
        }
    ?>
</div>
</body>
</html>