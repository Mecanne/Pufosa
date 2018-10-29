<?php
    require_once("../funciones.php");
    $conexion = conectar("pufosa");
    switch($_REQUEST['tabla']){
        case "clientes":
            $maximo_id = select("select max(CLIENTE_ID) as max from cliente");
            $maximo_id = mysqli_fetch_array($maximo_id);
            //echo ($maximo_id['max']+1)."<br>";
            $vendedor_id = select("select empleado_ID from empleados where Nombre = '".$_REQUEST['Nombre']."'");
            $vendedor_id = mysqli_fetch_array($vendedor_id);
            //echo $vendedor_id['empleado_ID'];
            if(mysqli_query($conexion,"insert into cliente values(".($maximo_id['max']+1)."
                                                    ,'".$_REQUEST['nombre']."'
                                                    ,'".$_REQUEST['Direccion']."'
                                                    ,'".$_REQUEST['Ciudad']."'
                                                    ,'".$_REQUEST['Estado']."'
                                                    ,".$_REQUEST['CodigoPostal']."
                                                    ,".$_REQUEST['CodigoDeArea']."
                                                    ,".$_REQUEST['Telefono']."
                                                    ,".$vendedor_id['empleado_ID']."
                                                    ,".$_REQUEST['Limite_De_Credito']."
                                                    ,'')") or die("Problemas con la consulta.".mysqli_error($conexion))) header("Location: clientes.php?addsuccess=1");

            break;
        //Otros casos
    }
?>