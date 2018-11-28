<?php
    session_start();
    if(!isset($_SESSION['emp_id'])) header("Location: ../index.php");
    require_once("../funciones.php");
    $conexion = conectar("pufosa");
    // Recogemos los datos del emppleado que va a realizar la operacion.
    $empleado = mysqli_query($conexion,"select CONCAT(Nombre,' ',Apellido,' ',Inicial_del_segundo_apellido) as Nombre from empleados where empleado_id = '".$_SESSION['emp_id']."'");
    /**
     * Cada uno de estos ID indica a que tabla quieres añadir datos.
     * En cada opcion, realiza la consulta y si se ejecuta correctamente, te redirige
     * a la pagina correspondiente con la confirmacion de si el dato se ha añadido o no.
     */
    if(isset($_REQUEST['CLIENTE_ID'])){
        $maximo_id = mysqli_query($conexion,"select max(CLIENTE_ID) as max from cliente");
        $maximo_id = mysqli_fetch_array($maximo_id);
        echo $_REQUEST['empleadosNombre']."<br>";
        if(mysqli_query($conexion,"insert into cliente values(".($maximo_id['max']+1)."
                                                ,'".$_REQUEST['nombre']."'
                                                ,'".$_REQUEST['Direccion']."'
                                                ,'".$_REQUEST['Ciudad']."'
                                                ,'".$_REQUEST['Estado']."'
                                                ,".$_REQUEST['CodigoPostal']."
                                                ,".$_REQUEST['CodigoDeArea']."
                                                ,".$_REQUEST['Telefono']."
                                                ,".$_REQUEST['empleadosNombre']."
                                                ,".$_REQUEST['Limite_De_Credito']."
                                                ,'".$_REQUEST['Comentarios']."')") or die("Problemas con la consulta: ".mysqli_error($conexion))){
            escribirEn("../ficheros/log.txt","El empleado ".mysqli_fetch_array($empleado)['Nombre']." ha añadido el cliente \"".$_REQUEST['nombre']."\".");
            header("Location: ../tablas/clientes.php?añadido=1");
            
        }else{
            header("Location: ../tablas/clientes.php?añadido=0");
        }

    }else
    if(isset($_REQUEST['empleado_ID'])){
        $maximo_id = mysqli_query($conexion,"select max(empleado_ID) as max from empleados");
        $maximo_id = mysqli_fetch_array($maximo_id);
        $query = "insert into empleados values(".($maximo_id['max']+1)."
                                                ,'".$_REQUEST['Apellido']."'
                                                ,'".$_REQUEST['Nombre']."'
                                                ,'".$_REQUEST['Inicial_del_segundo_apellido']."'
                                                ,".$_REQUEST['trabajosFuncion']."
                                                ,".$_REQUEST['empleadosNombre']."
                                                ,'".$_REQUEST['Fecha_contrato']."'
                                                ,".$_REQUEST['Salario']."
                                                ,".$_REQUEST['Comision']."
                                                ,".$_REQUEST['departamentoNombre'].")";
        echo $query;
        if(mysqli_query($conexion,$query)or die("Problemas con el select:".$query." | ".mysqli_error($conexion))) header("Location: ../tablas/empleados.php?añadido=true");
        else header("Location: ../tablas/empleados.php?añadido=0");
    }else
    if(isset($_REQUEST['Trabajo_ID'])){
        $maximo_id = mysqli_query($conexion,"select max(Trabajo_ID) as max from trabajos");
        $maximo_id = mysqli_fetch_array($maximo_id);
        $query = "insert into trabajos values(".($maximo_id['max']+1)."
                                                ,'".$_REQUEST['Funcion']."')";
        echo $query;
        if(mysqli_query($conexion,$query)or die("Problemas con el select".mysqli_error($conexion))) header("Location: ../tablas/trabajos.php?añadido=true");
        else header("Location: ../tablas/trabajos.php?añadido=0");
    }else
    if(isset($_REQUEST['departamento_ID'])){
        $maximo_id = mysqli_query($conexion,"select max(departamento_ID) as max from departamento");
        $maximo_id = mysqli_fetch_array($maximo_id);
        $query = "insert into departamento values(".($maximo_id['max']+1)."
                                                ,'".$_REQUEST['Nombre']."'
                                                ,'".$_REQUEST['ubicacionGrupoRegional']."')";
        echo $query;
        if(mysqli_query($conexion,$query)or die("Problemas con el select".mysqli_error($conexion))) header("Location: ../tablas/departamentos.php?añadido=true");
        else header("Location: ../tablas/departamentos.php?añadido=0");
    }else
    if(isset($_REQUEST['Ubicacion_ID'])){
        $maximo_id = mysqli_query($conexion,"select max(Ubicacion_ID) as max from ubicacion") or die("Problemas con el select".mysqli_error($conexion));
        $maximo_id = mysqli_fetch_array($maximo_id)['max'];
        $query = "insert into ubicacion values(".($maximo_id+1)."
                                                ,'".$_REQUEST['GrupoRegional']."')";
        echo $query;
        if(mysqli_query($conexion,$query)or die("Problemas con el select".mysqli_error($conexion))) header("Location: ../tablas/ubicaciones.php?añadido=true");
        else header("Location: ../tablas/ubicaciones.php?añadido=0");
    }else{
        header("Location: ../index.php");
    }
    mysqli_close($conexion);
?>