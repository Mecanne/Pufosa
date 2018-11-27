<?php
        session_start();
        if(!isset($_SESSION['emp_id'])) header("Location: ../index.php");
        require_once("../funciones.php");
        $conexion = conectar("pufosa");
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Clientes</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
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
            echo '<div class="container alert alert-success" id="añadir">¡Cliente <strong>añadido</strong> con exito!</div>';
            ?>
                <script>ocultar("añadir")</script>
            <?php
        } 
        if(isset($_REQUEST['modificado'])){
             echo '<div class="container alert alert-success" id="modificar">¡Cliente <strong>modificado</strong> con exito!</div>';
             ?>
                <script>ocultar("modificar")</script>
            <?php
        }
        if(isset($_REQUEST['borrado'])){
            echo '<div class="container alert alert-success" id="borrar">¡Cliente <strong>borrado</strong> con exito!</div>';
            ?>
                <script>ocultar("borrar")</script>
            <?php
        } 
    //

        /**
         * Añadimos los modales:
         */
        añadirModal("clientes");

        /**
         * Se añade la opcion de flitrado
         */
        añadirFiltrado("clientes");
        
        /**
         * Imprimimos la tabla
         */
        if(isset($_REQUEST['filtro'])){ //Si hay un filtro puesto, se mostrará la tabla con determinado filtro.
            if($_REQUEST['filtro'] == 'Vendedor'){
                imprimirTabla($conexion,"clientes","select cliente.* from cliente,empleados where Vendedor_ID = empleado_ID and (empleados.Nombre like '%".$_REQUEST['valor']."%' OR empleados.Apellido like '%".$_REQUEST['valor']."%')");
            }else if($_REQUEST['filtro'] == 'Codigo postal'){
                imprimirTabla($conexion,"clientes","select cliente.* from cliente where CodigoPostal like '%".$_REQUEST['valor']."%'");
            }else if($_REQUEST['filtro'] == 'Codigo de area'){
                imprimirTabla($conexion,"clientes","select cliente.* from cliente where CodigoDeArea like '%".$_REQUEST['valor']."%'");
            }else if($_REQUEST['filtro'] == 'Codigo postal'){
                imprimirTabla($conexion,"clientes","select cliente.* from cliente where CodigoPostal like '%".$_REQUEST['valor']."%'");
            }else if($_REQUEST['filtro'] == 'Limite de credito'){
                imprimirTabla($conexion,"clientes","select cliente.* from cliente where Limite_de_credito like '%".$_REQUEST['valor']."%'");
            }else{
                imprimirTabla($conexion,"clientes","select cliente.* from cliente where ".$_REQUEST['filtro']." like '%".$_REQUEST['valor']."%'");
            }
            echo '<div class="container-fluid">
                    <a class="btn btn-primary btn-sm" href="clientes.php">Restaurar</a>
                </div>';
        }else{
            imprimirTabla($conexion,"clientes","select * from cliente");
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