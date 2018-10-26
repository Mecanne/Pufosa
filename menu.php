<?php
    session_start();    
    $conexion = mysqli_connect("localhost","root","","pufosa") or
        die("Problemas con la conexion.");
    
        require_once("funciones.php");

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>PUFO's app</title>
    <link rel="stylesheet" href="css/menu.css">
    <script src="../js/menu.js"></script>
</head>
<body>
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
            $trabajo = mysqli_fetch_array($trabajo);
        /**
         * Si no existe una sesion, comprueba que el empleado ingresado existe y despues crea una sesion y te muestra todas las opciones.
         */
        }else{
            
            $registros = mysqli_query($conexion,"select * from empleados where empleado_ID = '".$_REQUEST['user_id']."'")
                or die("Problemas con el select: ".mysqli_error($conexion));
            
            if($user = mysqli_fetch_array($registros)){
                $user_valido = true;
                $_SESSION['emp_id'] = $_REQUEST['user_id'];
                $trabajo = mysqli_query($conexion,"select Funcion 
                                                    from trabajos tra, empleados emp
                                                    where tra.Trabajo_ID = emp.trabajo_ID and emp.empleado_ID = '".$_SESSION['emp_id']."'")
                    or die("Problemas con el select.".mysqli_error($conexion));
                $trabajo = mysqli_fetch_array($trabajo);

            }else{
                $user_valido = false;
            }
        }

        if($user_valido)
        {
            $admin = ($trabajo['Funcion'] == "PRESIDENT") || ($trabajo['Funcion'] == "MANAGER");
            printBarra();
            echo "<h2>Bienvenido/a &nbsp;".$user['Nombre']."&nbsp;".$user['Apellido']."&nbsp;".$user['Inicial_del_segundo_apellido']."</h2><br>";
            echo ($admin)?"Es admin":"No es admin";
        }
    ?>
</body>
</html>