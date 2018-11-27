<?php
        session_start();
        if(!isset($_SESSION['emp_id'])) header("Location: ../index.php");
        require_once("../funciones.php");
        $conexion = conectar("pufosa");
        switch(comprobarAcceso($conexion,$_SESSION['emp_id'])){
            case 2:
            case 1:
                break;
            case 0:
                header("Location: ../menu.php");
        }
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Ubicacion</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="main.js"></script>
<!--BOOTSTRAP-->
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> 
<!---->
<script src="../js/app.js"></script>
</head>
<body>
    <div class="container-fluid">
        <?php
            $conexion = conectar("pufosa");
            /**
             * Imprimimos la barra de navegacion.
             */
            imprimirBarra($conexion,$_SESSION['emp_id']);
            
        //Mensajes de confirmacion
            /**
             * Analizamos si se ha añadido, borrado o modificado un dato de la tabla.
             */
            if(isset($_REQUEST['añadido'])){
                echo '<div class="container alert alert-success" id="añadir">¡Ubicación <strong>añadida</strong> con exito!</div>';
                echo '<script>ocultar("añadir")</script>';
            } 
            if(isset($_REQUEST['modificado'])){
                echo '<div class="container alert alert-success" id="modificar">¡Ubicación <strong>modificada</strong> con exito!</div>';
                echo '<script>ocultar("modifcar")</script>';
            }
            if(isset($_REQUEST['borrado'])){
                if($_REQUEST['borrado'] == 1) echo '<div class="container alert alert-success" id="borrar">¡Ubicación <strong>borrada</strong> con exito!</div>';
                else echo '<div class="container alert alert-danger" id="borrar">No se pudo realizar la operacion</div>';
                
                echo '<script>ocultar("borrar")</script>';
            } 
        //
            /**
             * Añadimos los modales:
             */

            añadirModal("ubicaciones");
            /**
             * Se añade la opcion de flitrado
             */

            añadirFiltrado("ubicaciones");
            
            /**
             * Imprimimos la tabla
             */
            if(isset($_REQUEST['filtro'])){
                imprimirTabla($conexion,"ubicaciones","select * from ubicacion where ".$_REQUEST['filtro']." like '%".$_REQUEST['valor']."%'");
                echo '<div class="container-fluid">
                        <a class="btn btn-primary btn-sm" href="ubicaciones.php">Restaurar</a>
                    </div>';
            }else{
                imprimirTabla($conexion,"ubicaciones","select * from ubicacion");
            }
            mysqli_close($conexion);
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