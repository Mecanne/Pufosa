

<?php
/**
 * Realizado por DANIEL DIAZ NAVAS
 */

    // Si ya hay una sesion, redirigirá al menu y alli cargará todo a traves de la sesion.
    session_start();
    if(isset($_SESSION['emp_id'])){
        header("Location: menu.php");
    }
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="css/index.css">
</head>
<body>
    <div class="container">
        <div>
            <img src="img/logo.png" alt="Logo de la empresa"> 
        </div>
        <form action="menu.php" method="post">
            <div>
                <span><strong>ID del empleado</strong></span><br>
                <input type="text" name="user_id" size="40" required>
            </div>
            <button class="btn" onclick="this.form.submit()">Acceder</button>
        </form>
    </div>
    <p>Copyrigth PUFO S.A.</p>
</body>
</html>