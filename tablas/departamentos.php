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
    <title>Departamentos</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../css/menu.css">
    <link rel="stylesheet" href="../css/tabla.css">
    <script src="../js/app.js"></script>
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
         * Imprimimos la barra de navegacion.
         */
        imprimirBarra($conexion,$_SESSION['emp_id']);
        
    //Mensajes de confirmacion
        /**
         * Analizamos si se ha añadido, borrado o modificado un dato de la tabla.
         */
        if(isset($_REQUEST['añadido'])){
            echo '<div class="container alert alert-success" id="añadir">¡Departamento <strong>añadido</strong> con exito!</div>';
            ?>
                <script>ocultar("añadir")</script>
            <?php
        } 
        if(isset($_REQUEST['modificado'])){
             echo '<div class="container alert alert-success" id="modificar">¡Departamento <strong>modificado</strong> con exito!</div>';
             ?>
                <script>ocultar("modificar")</script>
            <?php
        }
        if(isset($_REQUEST['borrado'])){
            echo '<div class="container alert alert-success" id="borrar">¡Departamento <strong>borrado</strong> con exito!</div>';
            ?>
                <script>ocultar("borrar")</script>
            <?php
        } 
    //
        /**
         * Añadimos los modales:
         */

        añadirModal("departamentos");
        /**
         * Se añade la opcion de flitrado
         */

        añadirFiltrado("departamentos");
        /**
         * Imprimimos la tabla
         */
        if(isset($_REQUEST['filtro'])){
            if($_REQUEST['filtro'] == "Ubicacion"){
                imprimirTabla($conexion,"departamentos","select * from departamento,ubicacion where departamento.Ubicacion_ID = ubicacion.Ubicacion_ID and ubicacion.GrupoRegional LIKE '%".$_REQUEST['valor']."%'");
            }else{
                imprimirTabla($conexion,"departamentos","select * from departamento where ".$_REQUEST['filtro']." = '".$_REQUEST['valor']."'");
            }
            echo '<div class="container-fluid">
                    <a class="btn btn-primary btn-sm" href="departamentos.php">Restaurar</a>
                </div>';
        }else{
            imprimirTabla($conexion,"departamentos","select * from departamento");
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