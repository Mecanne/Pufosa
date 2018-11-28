<?php
    session_start();
    $conexion = mysqli_connect("localhost","root","","pufosa") or
        die("Problemas con la conexion.");
    
    require_once("funciones.php");

    /**
     * Si hay una sesion iniciada, cogerá los datos de esa sesion.
     */
    if(isset($_SESSION['emp_id'])){
        $user_valido = true; // Declaramos que es un usuario valido.
        //Recogemos los datos del empleado ya ingresado y establecemos su funcion en la empresa.
        $registros = mysqli_query($conexion,"select * from empleados where empleado_ID = '".$_SESSION['emp_id']."'") or
            die("Problemas con el select: ".mysqli_error($conexion));
        $user = mysqli_fetch_array($registros);
        $trabajo = $user['Trabajo_ID'];

    /**
     * Si no existe una sesion, comprueba que el empleado ingresado existe y despues crea una sesion y establece que si es o no un usuario valido.
     */
    }else if(isset($_REQUEST['user_id'])){
        
        $registros = mysqli_query($conexion,"select * from empleados where empleado_ID = '".$_REQUEST['user_id']."'")
            or die("Problemas con el select: ".mysqli_error($conexion));
        
        if($user = mysqli_fetch_array($registros)){
            $user_valido = true;
            $_SESSION['emp_id'] = $_REQUEST['user_id'];
            $trabajo = $user['Trabajo_ID'];

        }else{
            $user_valido = false;
        }
    // Si no te devuelve al login de la aplicacion.
    }else{
        header("Location: index.php");
    }

    /**
     * Si el ususario ingresado es valido te redirige a la tabla clientes.
     */
    if($user_valido)
    {
        header("Location: tablas/clientes.php");
    }