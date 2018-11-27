<?php
    session_start();
    if(!isset($_SESSION['emp_id'])) header("Location: ../index.php");
    require_once("../funciones.php");
    $conexion = conectar("pufosa");
    $empleado = mysqli_query($conexion,"select CONCAT(Nombre,' ',Apellido,' ',Inicial_del_segundo_apellido) as Nombre from empleados where empleado_id = '".$_SESSION['emp_id']."'");
    if(isset($_REQUEST['cliente-modificado'])){
        $query = "
            UPDATE cliente
                SET nombre = \"".$_REQUEST['nombre']."\",
                    Direccion = '".$_REQUEST['Direccion']."',
                    Ciudad ='".$_REQUEST['Ciudad']."',
                    Estado = '".$_REQUEST['Estado']."', 
                    CodigoPostal = '".$_REQUEST['CodigoPostal']."',
                    CodigoDeArea = '".$_REQUEST['CodigoDeArea']."',
                    Telefono = '".$_REQUEST['Telefono']."',
                    Vendedor_ID = '".$_REQUEST['empleadosNombre']."',
                    Limite_De_Credito = '".$_REQUEST['Limite_De_Credito']."' 
                WHERE CLIENTE_ID = '".$_REQUEST['cliente-modificado']."'
        ";
        echo $query."<br>";
        escribirEn("../ficheros/log.txt","El empleado ".mysqli_fetch_array($empleado)['Nombre']." ha modificado el cliente \"".$_REQUEST['nombre']."\".");
        if(mysqli_query($conexion,$query)or die("Problemas con el select: ".mysqli_error($conexion))) header("Location: ../tablas/clientes.php?modificado=1");
    }else if(isset($_REQUEST['empleado-modificado'])){
        $query = "
            UPDATE empleados
                SET Apellido = '".$_REQUEST['Apellido']."',
                    Nombre = '".$_REQUEST['Nombre']."',
                    Inicial_del_segundo_apellido ='".$_REQUEST['Inicial_del_segundo_apellido']."',
                    Trabajo_ID = '".$_REQUEST['trabajosFuncion']."', 
                    Jefe_ID = '".$_REQUEST['empleadosNombre']."',
                    Fecha_contrato = '".$_REQUEST['Fecha_contrato']."',
                    Salario = '".$_REQUEST['Salario']."',
                    Comision = '".$_REQUEST['Comision']."',
                    Departamento_ID = '".$_REQUEST['departamentoNombre']."' 
                WHERE empleado_ID = '".$_REQUEST['empleado-modificado']."'
        ";
        echo $query."<br>";
        if(mysqli_query($conexion,$query)or die("Problemas con el select: ".mysqli_error($conexion))) header("Location: ../tablas/empleados.php?modificado=1");  
    }else if(isset($_REQUEST['trabajo-modificado'])){
        $query = "
        UPDATE trabajos
            SET Funcion = '".$_REQUEST['Funcion']."' 
            WHERE Trabajo_ID = '".$_REQUEST['trabajo-modificado']."'
        ";
        echo $query."<br>";
        if(mysqli_query($conexion,$query)or die("Problemas con el select: ".mysqli_error($conexion))) header("Location: ../tablas/trabajos.php?modificado=1");
    }else if(isset($_REQUEST['departamento-modificado'])){
        $query = "
        UPDATE departamento
            SET Nombre = '".$_REQUEST['Nombre']."',
                Ubicacion_ID = '".$_REQUEST['ubicacionGrupoRegional']."' 
            WHERE departamento_ID = '".$_REQUEST['departamento-modificado']."'
        ";
        echo $query."<br>";
        if(mysqli_query($conexion,$query)or die("Problemas con el select: ".mysqli_error($conexion))) header("Location: ../tablas/departamentos.php?modificado=1");
    }else if(isset($_REQUEST['ubicacion-modificada'])){
        $query = "
        UPDATE ubicacion
            SET GrupoRegional = '".$_REQUEST['GrupoRegional']."' 
            WHERE Ubicacion_ID = '".$_REQUEST['ubicacion-modificada']."'
        ";
        echo $query."<br>";
        if(mysqli_query($conexion,$query)or die("Problemas con el select: ".mysqli_error($conexion))) header("Location: ../tablas/ubicaciones.php?modificado=1");
    }else{
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
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
    
    imprimirBarra($conexion,$_SESSION['emp_id']);
    if(isset($_REQUEST['CLIENTE_ID'])){
        $registros = mysqli_query($conexion,"select * from cliente where CLIENTE_ID = '".$_REQUEST['CLIENTE_ID']."'") or die("Problemas con el select".mysqli_error($conexion));
        if($reg = mysqli_fetch_array($registros)){
            echo '<h2 class="jumbotron" style="text-align:center;">Modificar cliente</h2>';
            $vendedor = mysqli_query($conexion,"select CONCAT(Nombre,' ',Apellido) as Nombre from empleados where empleado_ID = '".$reg['Vendedor_ID']."'") or die("Problemas con el select");
            $nombre_vendedor = mysqli_fetch_array($vendedor)['Nombre'];
            echo '<div class="container-fluid" style="display:block;margin:auto;max-width: 600px;">';
                echo '<form method="POST" action="modificar.php" class="form form-horizontal well">';
                    echo "Nombre: ".'<input type="text" name="nombre" value="'.$reg['nombre'].'" class="form-control">'.'<br>';
                    echo "Direccion: ".'<input type="text" name="Direccion" value="'.$reg['Direccion'].'" class="form-control">'.'<br>';
                    echo "Ciudad: ".'<input type="text" name="Ciudad" value="'.$reg['Ciudad'].'" class="form-control">'.'<br>';
                    echo "Estado: ".'<input type="text" name="Estado" value="'.$reg['Estado'].'" class="form-control">'.'<br>';
                    echo "Codigo postal: ".'<input type="number" name="CodigoPostal" value="'.$reg['CodigoPostal'].'" class="form-control">'.'<br>';
                    echo "Codigo de area: ".'<input type="number" name="CodigoDeArea" value="'.$reg['CodigoDeArea'].'" class="form-control">'.'<br>';
                    echo "Telefono: ".'<input type="text" name="Telefono" value="'.$reg['Telefono'].'" class="form-control">'.'<br>';
                    echo "Vendedor: ";
                        crearSelectedEspecifico("empleados","Nombre","select CONCAT(Nombre,' ',Apellido) as Nombre,empleado_ID from empleados  where Trabajo_ID = '670' ORDER BY Nombre ASC",$nombre_vendedor);
                    echo "<br>Limite de credito: ".'<input type="number" name="Limite_De_Credito" value="'.$reg['Limite_De_Credito'].'" class="form-control">'.'<br>';
                    echo '<input type="hidden" name="cliente-modificado" value="'.$_REQUEST['CLIENTE_ID'].'">';
                    echo '<div style="display: flex;justify-content:space-around;">';
                        echo '<input type="submit" class="btn btn-primary btn-lg" value="Modificar">';
                    echo '</div>';
                echo "</form>";
            echo "</div>";
        }
    }else
    if(isset($_REQUEST['empleado_ID'])){
        $registros = mysqli_query($conexion,"select * from empleados where empleado_ID = '".$_REQUEST['empleado_ID']."'") or die("Problemas con el select".mysqli_error($conexion));
        if($reg = mysqli_fetch_array($registros)){
            echo '<h2 class="jumbotron" style="text-align:center;">Modificar Empleado</h2>';
            $jefes = mysqli_query($conexion,"select CONCAT(Nombre,' ',Apellido) as Nombre from empleados where empleado_ID = '".$reg['Jefe_ID']."'") or die("Problemas con el select");
            $nombre_jefe = mysqli_fetch_array($jefes)['Nombre'];
            $trabajos = mysqli_query($conexion,"select Funcion from trabajos where Trabajo_ID = '".$reg['Trabajo_ID']."'") or die("Problemas con el select");
            $nombre_trabajo = mysqli_fetch_array($trabajos)['Funcion'];
            $departamentos = mysqli_query($conexion,"select CONCAT(Nombre,' en ',GrupoRegional) as Nombre from departamento,ubicacion where departamento_ID = '".$reg['Departamento_ID']."' and departamento.Ubicacion_ID = ubicacion.Ubicacion_ID") or die("Problemas con el select: ".mysqli_error($conexion));
            $nombre_departamento = mysqli_fetch_array($departamentos)['Nombre'];
            echo '<div class="container-fluid" style="display:block;margin:auto;max-width: 600px;">';
                echo '<form method="POST" action="modificar.php" class="form form-horizontal well">';
                    echo "Nombre: ".'<input type="text" name="Nombre" value="'.$reg['Nombre'].'" class="form-control">'.'<br>';
                    echo "Apellido: ".'<input type="text" name="Apellido" value="'.$reg['Apellido'].'" class="form-control">'.'<br>';
                    echo "Inicial del segundo apellido: ".'<input type="text" name="Inicial_del_segundo_apellido" value="'.$reg['Inicial_del_segundo_apellido'].'" class="form-control">'.'<br>';
                    echo "Trabajo: ";
                        crearSelectedEspecifico("trabajos","Funcion","select Funcion,Trabajo_ID from trabajos where Trabajo_ID <> '672'",$nombre_trabajo);
                    echo "Jefe: ";
                        crearSelectedEspecifico("empleados","Nombre","select CONCAT(Nombre,' ',Apellido) as Nombre,empleado_ID from empleados",$nombre_jefe);
                    echo "Fecha de contratacion: ".'<input type="date" name="Fecha_contrato" value="'.$reg['Fecha_contrato'].'" class="form-control">'.'<br>';
                    echo "Salario: ".'<input type="number" name="Salario" value="'.$reg['Salario'].'" class="form-control">'.'<br>';;
                    echo "Comision: ".'<input type="number" name="Comision" value="'.$reg['Comision'].'" class="form-control">'.'<br>';
                    echo "Departamento: <br>";
                        crearSelectedEspecifico("departamento","Nombre","select CONCAT(Nombre,' en ',GrupoRegional) as Nombre,departamento_ID from departamento,ubicacion where departamento.Ubicacion_ID = ubicacion.Ubicacion_ID",$nombre_departamento);
                    echo '<br><input type="hidden" name="empleado-modificado" value="'.$reg['empleado_ID'].'">';
                    echo '<div style="display: flex;justify-content:space-around;">';
                        echo '<input type="submit" class="btn btn-primary btn-lg" value="Modificar">';
                        echo '<button type="button" class="btn btn-danger btn-lg" onclick="history(-1)">Cancelar</button>';
                    echo '</div>';
                echo "</form>";
            echo "</div>";
        }
    }else
    if(isset($_REQUEST['Trabajo_ID'])){
        $registros = mysqli_query($conexion,"select * from trabajos where Trabajo_ID = '".$_REQUEST['Trabajo_ID']."'") or die("Problemas con el select".mysqli_error($conexion));
        if($reg = mysqli_fetch_array($registros)){
            echo '<h2 class="jumbotron" style="text-align:center;">Modificar Trabajo</h2>';
            echo '<div class="container-fluid" style="display:block;margin:auto;max-width: 600px;">';
                echo '<form method="POST" action="modificar.php" class="form-horizontal">';
                    echo "Nombre: ".'<input type="text" name="Funcion" value="'.$reg['Funcion'].'" class="form-control">'.'<br>';
                    echo '<br><input type="hidden" name="trabajo-modificado" value="'.$reg['Trabajo_ID'].'">';
                    echo '<div style="display: flex;justify-content:space-around;">';
                        echo '<input type="submit" class="btn btn-primary btn-lg" value="Modificar">';
                        echo '<button type="button" class="btn btn-danger btn-lg" onclick="history(-1)">Cancelar</button>';
                    echo '</div>';
                echo "</form>";
            echo "</div>";
        }
    }else
    if(isset($_REQUEST['departamento_ID'])){
        $registros = mysqli_query($conexion,"select * from departamento where departamento_ID = '".$_REQUEST['departamento_ID']."'") or die("Problemas con el select".mysqli_error($conexion));
        if($reg = mysqli_fetch_array($registros)){
            $ubicacion = mysqli_query($conexion,"select GrupoRegional from ubicacion,departamento where ubicacion.Ubicacion_ID = departamento.Ubicacion_ID and departamento_ID = '".$_REQUEST['departamento_ID']."'");
            $ubi = mysqli_fetch_array($ubicacion);
            echo '<h2 class="jumbotron" style="text-align:center;">Modificar Departamento</h2>';
            echo '<div class="container-fluid" style="display:block;margin:auto;max-width: 600px;">';
                echo '<form method="POST" action="modificar.php" class="form-horizontal">';
                    echo "Nombre: ".'<input type="text" name="Nombre" value="'.$reg['Nombre'].'" class="form-control">'.'<br>';
                    echo "Ubicacion: <br>";
                        crearSelectedEspecifico("ubicacion","GrupoRegional","select GrupoRegional,Ubicacion_ID from ubicacion",$ubi['GrupoRegional']);
                    echo '<br><input type="hidden" name="departamento-modificado" value="'.$reg['departamento_ID'].'">';
                    echo '<div style="display: flex;justify-content:space-around;">';
                        echo '<input type="submit" class="btn btn-primary btn-lg" value="Modificar">';
                        echo '<button type="button" class="btn btn-danger btn-lg" onclick="history(-1)">Volver</button>';
                    echo '</div>';
                echo "</form>";
            echo "</div>";
        }
    }else
    if(isset($_REQUEST['Ubicacion_ID'])){
        $registros = mysqli_query($conexion,"select * from ubicacion where Ubicacion_ID = '".$_REQUEST['Ubicacion_ID']."'") or die("Problemas con el select".mysqli_error($conexion));
        if($reg = mysqli_fetch_array($registros)){
            echo '<h2 class="jumbotron" style="text-align:center;">Modificar Ubicacion</h2>';
            echo '<div class="container-fluid" style="display:block;margin:auto;max-width: 600px;">';
                echo '<form method="POST" action="modificar.php" class="form-horizontal">';
                    echo "Nombre: ".'<input type="text" name="GrupoRegional" value="'.$reg['GrupoRegional'].'" class="form-control">'.'<br>';
                    echo '<br><input type="hidden" name="ubicacion-modificada" value="'.$reg['Ubicacion_ID'].'">';
                    echo '<div style="display: flex;justify-content:space-around;">';
                        echo '<input type="submit" class="btn btn-primary btn-lg" value="Modificar">';
                        echo '<button type="button" class="btn btn-danger btn-lg" onclick="history(-1)">Cancelar</button>';
                    echo '</div>';
                echo "</form>";
            echo "</div>";
        }
    }else
        {header("Location: ../index.php");}
}
mysqli_close($conexion);
?>
</div>
</body>
</html>