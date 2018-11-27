<?php
    session_start();
    if(!isset($_SESSION['emp_id'])) header("Location: ../index.php");
    $borrado = 1;
    require_once("../funciones.php");
    $conexion = conectar("pufosa");
    $empleado = mysqli_query($conexion,"select CONCAT(Nombre,' ',Apellido,' ',Inicial_del_segundo_apellido) as Nombre from empleados where empleado_id = '".$_SESSION['emp_id']."'");
    if(isset($_REQUEST['CLIENTE_ID'])){
        $cliente = mysqli_query($conexion,"select Nombre from cliente where CLIENTE_ID = '".$_REQUEST['CLIENTE_ID']."'");
        mysqli_query($conexion,"delete from cliente where CLIENTE_ID ='".$_REQUEST['CLIENTE_ID']."'") or $borrado = 0;
        mysqli_close($conexion);
        escribirEn("../ficheros/log.txt","El empleado ".mysqli_fetch_array($empleado)['Nombre']." ha borrado el cliente \"".mysqli_fetch_array($cliente)['Nombre']."\".");
        header("Location: ../tablas/clientes.php?borrado=".$borrado);
    }else
    if(isset($_REQUEST['empleado_ID'])){
        mysqli_query($conexion,"delete from empleados where empleado_ID ='".$_REQUEST['empleado_ID']."'") or die("Problemas con el select: ".mysqli_error($conexion));
        mysqli_close($conexion);
        header("Location: ../tablas/empleados.php?borrado=1");
    }else
    if(isset($_REQUEST['Trabajo_ID'])){
        mysqli_query($conexion,"delete from trabajos where Trabajo_ID ='".$_REQUEST['Trabajo_ID']."'") or die("Problemas con el select: ".mysqli_error($conexion));
        mysqli_close($conexion);
        header("Location: ../tablas/trabajos.php?borrado=1");
    }else
    if(isset($_REQUEST['departamento_ID'])){
        mysqli_query($conexion,"delete from departamento where departamento_ID ='".$_REQUEST['departamento_ID']."'") or die("Problemas con el select: ".mysqli_error($conexion));
        mysqli_close($conexion);
        header("Location: ../tablas/departamentos.php?borrado=1");
    }else
    if(isset($_REQUEST['Ubicacion_ID'])){
        mysqli_query($conexion,"delete from ubicacion where Ubicacion_ID ='".$_REQUEST['Ubicacion_ID']."'") or $borrado = 0;
        mysqli_close($conexion);
        header("Location: ../tablas/ubicaciones.php?borrado=".$borrado);
    }else
        {header("Location: ../index.php");}
?>