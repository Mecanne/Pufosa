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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Log</title>
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
<div class="container">
    <h2>Log:</h2>
    <div class="container">
        <input class="form-control" id="myInput" type="text" placeholder="Buscar..">
        <br>
    </div>
    <div class="container panel panel-default">
        <div class="panel-body" id="datos">
            <?php
                $fichero = fopen("../ficheros/log.txt","r") or
                    die("El fichero no se ha podido abrir.");
                while(!feof($fichero)){
                    $linea = fgets($fichero);
                    $lineaSalto = nl2br($linea);
                    echo '<p>'.$lineaSalto.'</p>';
                }
            ?>
        </div>
    </div>
</div>
    <script>
        $(document).ready(function(){
            $("#myInput").on("keyup", function() {
                var value = $(this).val().toLowerCase();
                    $("#datos p").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });
        });
    </script> 
</body>
</html>