<?php
    /**
     * Funcion que te conecta a una determinada base de datos con el ususario root.
     */
    function conectar($base){
        $conexion = mysqli_connect("localhost","root","",$base) or
            die("Problemas de conexión");
        return $conexion;
    }
    
    /**
     * Escribe un mensaje en el archivo especificao en la ruta.
     * @param String $ruta Ruta del archivo a escribir
     * param {Mensaje a escribir en la ruta} $mensaje
    */
    function escribirEn($ruta,$mensaje){
        $fichero = fopen($ruta,"a");
        fputs($fichero,date("Y-m-d H:i:s")." : ".$mensaje);
        fputs($fichero,"\n");
        fclose($fichero);
    }

    function imprimirBarra($conexion,$id){
        $registros = mysqli_query($conexion,"select * from empleados where empleado_ID = '".$id."'");
        $reg = mysqli_fetch_array($registros);
        $trabajo = $reg['Trabajo_ID'];
        $username = $reg['Nombre'].' '.$reg['Apellido'].' '.$reg['Inicial_del_segundo_apellido'];
        
        switch($trabajo){
            case '672':
                echo '
                <div class="row">
                    <nav class="navbar navbar-inverse" style="border-radius: 0px;">
                        <div class="container-fluid">
                            <div class="navbar-header">
                                <span class="navbar-brand active" style="color:white;" href="">PUFO S.A</span>
                            </div>
                            <ul class="nav navbar-nav">
                                <li><a href="../tablas/clientes.php">Clientes</a></li>
                                <li><a href="../tablas/empleados.php">Empleados</a></li>
                                <li><a href="../tablas/trabajos.php">Trabajos</a></li>
                                <li><a href="../tablas/departamentos.php">Departamentos</a></li>
                                <li><a href="../tablas/ubicaciones.php">Ubicaciones</a></li>
                                <li><a href="../operaciones/log.php" target="_blank">Log</a></li>
                                <li><a href="../tablas/informe.php">Informe</a></li>
                            </ul>
                            <ul class="nav navbar-nav navbar-right">
                                <li><a style="color: white;" href="../operaciones/logout.php">Cerrar sesión</a></li>
                            </ul>
                            <p class="nav navbar-nav navbar-right navbar-text">'.$username.'</p>
                        </div>
                    </nav>
                </div>
                ';
                break;
            case '671':
                echo '
                <div class="row">
                    <nav class="navbar navbar-inverse" style="border-radius: 0px;">
                        <div class="container-fluid">
                            <div class="navbar-header">
                                <span class="navbar-brand active" style="color:white;" href="">PUFO S.A</span>
                            </div>
                            <ul class="nav navbar-nav">
                                <li><a href="../tablas/clientes.php">Clientes</a></li>
                                <li><a href="../tablas/empleados.php">Empleados</a></li>
                                <li><a href="../tablas/trabajos.php">Trabajos</a></li>
                                <li><a href="../tablas/departamentos.php">Departamentos</a></li>
                                <li><a href="../tablas/ubicaciones.php">Ubicaciones</a></li>
                                <li><a href="../operaciones/log.php" target="_blank">Log</a></li>
                            </ul>
                            <ul class="nav navbar-nav navbar-right">
                                <li><a style="color: white;" href="../operaciones/logout.php">Cerrar sesión</a></li>
                            </ul>
                            <p class="nav navbar-nav navbar-right navbar-text">'.$username.'</p>
                        </div>
                    </nav>
                </div>
                ';
                break;
            default:
                echo '
                <div class="row">
                    <nav class="navbar navbar-inverse" style="border-radius: 0px;">
                        <div class="container-fluid">
                            <div class="navbar-header">
                                <span class="navbar-brand active" style="color:white;" href="">PUFO S.A</span>
                            </div>
                            <ul class="nav navbar-nav navbar-right">
                                <li><a style="color: white;" href="../operaciones/logout.php">Cerrar sesión</a></li>
                            </ul>
                            <p class="nav navbar-nav navbar-right navbar-text">'.$username.'</p>
                        </div>
                    </nav> 
                </div>
                ';
        }
    }
    /**
     * Crea los botones para modificar y borrar los registros de una tabla.
     */
    function crearBotones($id,$name){
        echo '
        <td>
        <div class="container-fluid" style="display:flex;justify-content:space-around;">
            <form method="POST" action="../operaciones/modificar.php" style="display:inline;">
                <div style="display: flex;">
                    <input type="submit" class="btn btn-warning" value="MODIFICAR" style="margin: 0px 10px 0px 0px;">
                    <input type="hidden" name="'.$name.'" value="'.$id.'">
                </div>
            </form>
            <form method="POST" action="../operaciones/borrar.php">
                <div style="display: flex;">
                    <input class="btn btn-danger" name="button" type=button
                        onclick="if(confirm(\'¿Seguro que desea borrar este dato?\')){
                                this.form.submit();}
                            else{ 
                                alert(\'Operacion Cancelada\');
                            }" 
                        value="ELIMINAR" 
                    />
                    <input type="hidden" name="'.$name.'" value="'.$id.'">
                </div>
            </form>
        </div> 
        </td>
        ';
    }

    /**
     * Funcion que imprime una tabla en funcion de sus parametros
     * 
     * param "tabla": se usa para identiciar que parametros se pueden mostrar sobre cada tabla.
     * param "consulta": equivale a la consulta sobre la tabla deseada. 
     */
    function imprimirTabla($conexion,$tabla,$consulta){
        switch($tabla){
            case "clientes":
                $registros = mysqli_query($conexion,$consulta." ORDER BY nombre ASC") or die("Problemas con la conexion:".mysqli_error($conexion));
                echo '<div class="container-fluid table-responsive">';
                echo '<table class="table table-hover table-striped table-condensed">
                        <thead>
                            <tr style="background-color: rgba(0,0,0,0.85);color:white;">
                                <th>Nombre</th>
                                <th>Direccion</th>
                                <th>Ciudad</th>
                                <th>Estado</th>
                                <th>Codigo postal</th>
                                <th>Codigo de area</th>
                                <th>Telefono</th>
                                <th>Vendedor</th>
                                <th>Limite de credito</th>
                                <th>Comentarios</th>
                                <th style="text-align:center;">Opciones</th>
                            </tr>
                        </thead>
                        <tbody id="tablaDatos">';
                while($reg = mysqli_fetch_array($registros)){
                    $vendedores = mysqli_query($conexion,"select * from empleados where empleado_ID ='".$reg['Vendedor_ID']."'") or die("Problemas con el select");
                    $vendedor = mysqli_fetch_array($vendedores);
                    echo '<tr>
                            <td>'.$reg['nombre'].'</td>
                            <td>'.$reg['Direccion'].'</td>
                            <td>'.$reg['Ciudad'].'</td>
                            <td>'.$reg['Estado'].'</td>
                            <td>'.$reg['CodigoPostal'].'</td>
                            <td>'.$reg['CodigoDeArea'].'</td>
                            <td>'.$reg['Telefono'].'</td>
                            <td>'.$vendedor['Nombre'].'&nbsp;'.$vendedor['Apellido'].'</td>
                            <td>'.$reg['Limite_De_Credito'].'</td>
                            <td>'.$reg['Comentarios'].'</td>';
                        crearBotones($reg['CLIENTE_ID'],"CLIENTE_ID");
                        echo '</tr>'; 
                }
                echo '      </tbody>
                        </table>
                    </div>';
                break;
            case "empleados":
                $registros = mysqli_query($conexion,$consulta." ORDER BY nombre ASC") or die("Problemas con la conexion:".mysqli_error($conexion));
                $columnas = getColumnas($tabla);
                echo '<div class="container-fluid">';
                echo '<table class="table table-dark table-hover">';
                echo '<thead>
                        <tr style="background-color: rgba(0,0,0,0.85);color:white;">
                            <th>Nombre</th>
                            <th>Apellido</th>
                            <th>Inicial del segundo apellido</th>
                            <th>Trabajo</th>
                            <th>Jefe</th>
                            <th>Fecha de contratación</th>
                            <th>Salario</th>
                            <th>Comision</th>
                            <th>Departamento</th>
                            <th style="text-align:center;">Opciones</th>
                        </tr>
                    </thead>
                    <tbody id="tablaDatos">';
                while($reg = mysqli_fetch_array($registros)){
                    $jefes = mysqli_query($conexion,"select * from empleados where empleado_ID ='".$reg['Jefe_ID']."'") or die("Problemas con el select".mysqli_error($conexion));
                    $jefe = mysqli_fetch_array($jefes);
                    $departamentos = mysqli_query($conexion,"select * from departamento where departamento_ID='".$reg['Departamento_ID']."'") or die("Problemas con el select".mysqli_error($conexion));
                    $departamento = mysqli_fetch_array($departamentos);
                    $trabajos = mysqli_query($conexion,"select * from trabajos where trabajo_ID='".$reg['Trabajo_ID']."'") or die("Problemas con el select");
                    $trabajo = mysqli_fetch_array($trabajos);
                    $ubicaciones = mysqli_query($conexion,"select GrupoRegional from ubicacion where Ubicacion_ID='".$departamento['Ubicacion_ID']."'") or die("Problemas con el select: ".mysqli_error($conexion));
                    $ubicacion = mysqli_fetch_array($ubicaciones);
                    echo '<tr>
                        <td>'.$reg['Nombre'].'</td>
                        <td>'.$reg['Apellido'].'</td>
                        <td>'.$reg['Inicial_del_segundo_apellido'].'</td>
                        <td>'.$trabajo['Funcion'].'</td>
                        <td>'.$jefe['Nombre'].'&nbsp;'.$jefe['Apellido'].'</td>
                        <td>'.$reg['Fecha_contrato'].'</td>
                        <td>'.$reg['Salario'].'</td>
                        <td>'.$reg['Comision'].'</td>
                        <td>'.ucfirst($departamento['Nombre']) .' en '.$ubicacion['GrupoRegional'].'</td>';
                    crearBotones($reg['empleado_ID'],"empleado_ID");
                    echo '</tr>'; 
                }
                echo '      </tbody>
                        </table>
                    </div>';
                break;
            case "trabajos":
                    $registros = mysqli_query($conexion,$consulta." ORDER BY Funcion ASC") or die("Problemas con la conexion:".mysqli_error($conexion));
                    $columnas = getColumnas($tabla);
                    echo '<div class="container-fluid">';
                    echo '<table class="table table-dark table-hover">';
                    echo '<thead><tr style="background-color: rgba(0,0,0,0.85);color:white;">
                            <th>Funcion</th>
                            <th style="text-align:center;">Opciones</th>
                        </tr>
                        </thead>
                        <tbody id="tablaDatos">';
                    while($reg = mysqli_fetch_array($registros)){
                        echo '<tr><td>'.$reg['Funcion'].'</td>';
                        crearBotones($reg['Trabajo_ID'],"Trabajo_ID");
                        echo '</tr>'; 
                    }
                    echo '      </tbody>
                        </table>
                    </div>';
                    break;
            case "ubicaciones":
                $registros = mysqli_query($conexion,$consulta." ORDER BY GrupoRegional ASC") or die("Problemas con la conexion:".mysqli_error($conexion));
                $columnas = getColumnas($tabla);
                echo '<div class="container-fluid">';
                echo '<table class="table table-striped table-hover">';
                echo '<thead><tr style="background-color: rgba(0,0,0,0.85);color:white;">
                        <th>Grupo regional</th>
                        <th style="text-align:center;">Opciones</th>
                    </tr>
                    </thead>
                    <tbody id="tablaDatos">';
                while($reg = mysqli_fetch_array($registros)){
                    echo '<tr><td>'.$reg['GrupoRegional'].'</td>';
                    crearBotones($reg['Ubicacion_ID'],"Ubicacion_ID");
                    echo '</tr>'; 
                }
                echo '      </tbody>
                        </table>
                    </div>';
                break;
            case "departamentos":
                $registros = mysqli_query($conexion,$consulta." ORDER BY Nombre ASC") or die("Problemas con la conexion:".mysqli_error($conexion));
                $columnas = getColumnas($tabla);
                echo '<div class="container-fluid">';
                echo '<table class="table table-striped table-hover ">';
                echo '<thead><tr style="background-color: rgba(0,0,0,0.85);color:white;">
                        <th>Nombre</th>
                        <th>Ubicacion</th>
                        <th style="text-align:center;">Opciones</th>
                    </tr>
                    </thead>
                    <tbody id="tablaDatos">
                    ';
                while($reg = mysqli_fetch_array($registros)){
                    $ubicaciones = mysqli_query($conexion,"select * from ubicacion where Ubicacion_ID ='".$reg['Ubicacion_ID']."'") or die("Problemas con el select".mysqli_error($conexion));
                    $ubicacion = mysqli_fetch_array($ubicaciones);
                    echo '<tr>
                        <td>'.$reg['Nombre'].'</td>
                        <td>'.$ubicacion['GrupoRegional'].'</td>';
                    crearBotones($reg['departamento_ID'],"departamento_ID");
                    echo '</tr>'; 
                }
                echo '      </tbody>
                        </table>
                    </div>';
                break;
        }
    }

    /**
     * Muestra la opcion de añadir un determiando cliente a una 
     */
    function añadirModal($opcion){
        echo '<div class="container">';
        echo '<form action="../operaciones/añadir.php" method="POST">';
        $columnas = getColumnas($opcion);
        switch($opcion){
            case "clientes";
                echo '
                    <!-- Boton para activar el modal -->
                    <div class="container">
                        <button type="button" class="btn btn-info btn-block" data-toggle="modal" data-target="#añadir">Añadir cliente</button>
                    </div>
                    <!-- Modal -->
                    <div id="añadir" class="modal fade" role="dialog">
                        <div class="modal-dialog">
                        
                            <!-- Modal content-->
                            <div class="modal-content">
                                <div class="modal-header" style="background-color: rgba(0,0,0,0.85);color:white;">
                                    <h4 class="modal-title">Añadir cliente</h4>
                                </div>
                                <div class="modal-body">';
                                    for($i = 1; $i< sizeOf($columnas); $i++){
                                        ($columnas[$i] == "Limite_De_Credito" || $columnas[$i] == "Telefono" || $columnas[$i] == "CodigoDeArea" || $columnas[$i] == "CodigoPostal")?$type = "number":$type = "text";
                                        
                                        if($columnas[$i]== "Vendedor"){
                                            echo "Vendedor<br>";
                                            crearSelectEspecifico("empleados","Nombre","select CONCAT(Nombre,' ',Apellido) as Nombre,empleado_ID from empleados where Trabajo_ID = '670' ORDER BY Nombre ASC");
                                            echo "<br>";
                                            continue;
                                        }else{
                                            echo ucfirst($columnas[$i]);
                                            if($columnas[$i] == "Comentarios"){
                                                echo '<textarea class="form-control" name='.$columnas[$i].'></textarea><br>';
                                                continue;
                                            }
                                            echo '<input class="form-control" type="'.$type.'" name='.$columnas[$i].' required><br>';
                                        }
                                    }
                            echo '<input type="hidden" name="CLIENTE_ID">
                            </div>
                                <div class="modal-footer" style=" display:flex;background-color: rgba(0,0,0,0.85);color:white;justify-content:space-around;">
                                    <input type="submit" class="btn btn-primary btn-lg" value="Añadir">  
                                    <button type="button" class="btn btn-danger btn-lg" data-dismiss="modal">Cancelar</button>
                                </div>
                            </div>
                        </div>
                    </div>';
                break;
            case "empleados";
                echo '
                    <!-- Boton para activar el modal-->
                    <div class="container">
                        <button type="button" class="btn btn-info btn-block" data-toggle="modal" data-target="#añadir">Añadir empleado</button>
                    </div>                    
                    <!-- Modal -->
                    <div id="añadir" class="modal fade" role="dialog">
                        <div class="modal-dialog">
                        
                            <!-- Modal content-->
                            <div class="modal-content">
                                <div class="modal-header" style="background-color: rgba(0,0,0,0.85);color:white;">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title">Añadir empleado</h4>
                                </div>
                                <div class="modal-body">';
                                for($i = 1; $i< sizeOf($columnas); $i++){
                                    $type = "text";
                                    if($columnas[$i] == "Jefe_ID"){
                                        echo "Jefe";
                                        crearSelectEspecifico("empleados","Nombre","select CONCAT(Nombre,' ',Apellido) as Nombre,empleado_ID from empleados where Trabajo_ID <> '670' order by empleados.nombre asc");
                                        echo "<br>";
                                        continue;
                                    }else
                                    if($columnas[$i] == "Trabajo_ID"){
                                        echo "Trabajo";
                                        crearSelectEspecifico("trabajos","Funcion","select Funcion,Trabajo_ID from trabajos");
                                        echo "<br>";
                                        continue;
                                    }
                                    elseif($columnas[$i] == "Departamento_ID"){
                                        echo "Departamento";
                                        crearSelectEspecifico("departamento","Nombre","select CONCAT(dep.Nombre,' en ',ubi.GrupoRegional) as Nombre,departamento_ID from departamento dep, ubicacion ubi where ubi.Ubicacion_ID = dep.Ubicacion_ID order by Nombre asc");
                                        echo "<br>";
                                        continue;
                                    }else if($columnas[$i] == "Comision" || $columnas[$i] == "Salario"){
                                        echo $columnas[$i]."<br>";
                                        $type = "number";
                                    }else if($columnas[$i] == "Fecha_contrato"){
                                        echo $columnas[$i]."<br>";
                                        $type = "date";
                                    }
                                    else{
                                        echo $columnas[$i]."<br>";
                                    }
                                    echo '<input type="'.$type.'" class="form-control" name='.$columnas[$i].' required><br>';
                                }
                                echo '<input type="hidden" name="empleado_ID">
                                </div>
                                <div class="modal-footer" style="background-color: rgba(0,0,0,0.85);color:white;">
                                    <input type="submit" class="btn btn-primary" value="Añadir">   
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                                </div>
                            </div>
                        
                        </div>
                    </div>
                ';
                break;
            case "trabajos";
                echo '
                    <!-- Boton para activar el modal -->
                    <div class="container">
                        <button type="button" class="btn btn-info btn-block" data-toggle="modal" data-target="#añadir">Añadir trabajo</button>
                    </div>
                    <!-- Modal -->
                    <div id="añadir" class="modal fade" role="dialog">
                        <div class="modal-dialog">
                        
                            <!-- Modal content-->
                            <div class="modal-content">
                                <div class="modal-header" style="background-color: rgba(0,0,0,0.85);color:white;">
                                    <h4 class="modal-title">Añadir trabajo</h4>
                                </div>
                                <div class="modal-body">';
                                    for($i = 1; $i< sizeOf($columnas); $i++){
                                        echo $columnas[$i]."<br>";
                                        echo '<input type="text" class="form-control" name='.$columnas[$i].' required><br>';
                                    }
                            echo '<input type="hidden" name="Trabajo_ID">
                            </div>
                                <div class="modal-footer" style="background-color: rgba(0,0,0,0.85);color:white;">
                                    <input type="submit" class="btn btn-primary" value="Añadir">  
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                                </div>
                            </div>
                        </div>
                    </div>';
                break;
            case "departamentos";
                echo '
                    <!-- Boton para activar el modal -->
                    <div class="container">
                        <button type="button" class="btn btn-info btn-block" data-toggle="modal" data-target="#añadir">Añadir departamento</button>
                    </div>
                    <!-- Modal -->
                    <div id="añadir" class="modal fade" role="dialog">
                        <div class="modal-dialog">
                        
                            <!-- Modal content-->
                            <div class="modal-content">
                                <div class="modal-header" style="background-color: rgba(0,0,0,0.85);color:white;">
                                    <h4 class="modal-title">Añadir departamento</h4>
                                </div>
                                <div class="modal-body">';
                                    for($i = 1; $i< sizeOf($columnas); $i++){
                                        if($columnas[$i]== "Ubicacion_ID"){
                                            echo "Grupo regional";
                                            crearSelectEspecifico("ubicacion","GrupoRegional","select GrupoRegional,Ubicacion_ID from ubicacion");
                                            echo "<br>";
                                            continue;
                                        }else{
                                            echo $columnas[$i];
                                        }
                                        echo '<input type="text" class="form-control" name='.$columnas[$i].' required><br>';
                                    }
                            echo '<input type="hidden" name="departamento_ID">
                            </div>
                                <div class="modal-footer" style="background-color: rgba(0,0,0,0.85);color:white;">
                                    <input type="submit" class="btn btn-primary" value="Añadir">  
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                                </div>
                            </div>
                        </div>
                    </div>';
                break;
            case "ubicaciones";
                
                echo '
                    <!-- Boton para activar el modal -->
                    <div class="container">
                        <button type="button" class="btn btn-info btn-block" data-toggle="modal" data-target="#añadir">Añadir ubicacion</button>
                    </div>
                    <!-- Modal -->
                    <div id="añadir" class="modal fade" role="dialog">
                        <div class="modal-dialog">
                        
                            <!-- Modal content-->
                            <div class="modal-content">
                                <div class="modal-header" style="background-color: rgba(0,0,0,0.85);color:white;">
                                    <h4 class="modal-title">Añadir ubicacion</h4>
                                </div>
                                <div class="modal-body">';
                                for($i = 1; $i< sizeOf($columnas); $i++){
                                    echo $columnas[$i];
                                    echo '<input type="text" class="form-control" name='.$columnas[$i].' required><br>';
                                }
                            echo '<input type="hidden" name="Ubicacion_ID">
                            </div>
                                <div class="modal-footer" style="background-color: rgba(0,0,0,0.85);color:white;">
                                    <input type="submit" class="btn btn-primary" value="Añadir">  
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                                </div>
                            </div>
                        </div>
                    </div>';
                break;
        }
        echo '<input type="hidden" name="añadido" value="'.$opcion.'">';
        echo '</form>';
        echo '</div>';
    }

    /**
     * Añade la opcion de filtrado para la consulta de tablas
     */
    function añadirFiltrado($opcion){
        $conexion = conectar("pufosa");
        $filtros = getColumnasFiltro($opcion);
        echo "<hr>";
        echo '<div class="container-fluid">';
        echo "<span> Filtrar por: </span>";
        switch($opcion){
            case 'clientes':
                echo '<form method="get" action="clientes.php" class="form">';
                break;
            case 'empleados':
                echo '<form method="get" action="empleados.php" class="form">';
                break;
            case 'trabajos':
                echo '<form method="get" action="trabajos.php" class="form">';
                break;
            case 'departamentos':
                echo '<form method="get" action="departamentos.php" class="form">';
                break;
            case 'ubicaciones':
                echo '<form method="get" action="ubicaciones.php" class="form">';
                break;
        }
            echo '<select name="filtro" class="form-control" style="display:inline;max-width:15%;">';
            for($i = 0; $i < sizeOf($filtros); $i++){
                echo '<option value="'.$filtros[$i].'">'.ucfirst($filtros[$i]).'</option>';
            }
            echo "</select>&nbsp;";
        echo '<input type="text" name="valor" value="" class="form-control" style="display:inline;max-width:30%;" required> ';
        echo '<input type="submit" class="btn btn-success btn-sm" value="Filtrar">';
        echo "</form>";
        echo '</div>';
        echo "<hr>";
        echo '
            <div class="container">
                <input class="form-control" id="myInput" type="text" placeholder="Buscar..">
                <br>
            </div>
        ';
    }

    /**
     * Devuelve un array que contiene el nombre de las columnas dependiendo de la tabla indicada en el parametro
     */
    function getColumnas($tabla){
        switch($tabla){
            case "clientes":
                $arr = ["CLIENTE_ID","nombre","Direccion","Ciudad","Estado","CodigoPostal","CodigoDeArea","Telefono","Vendedor","Limite_De_Credito","Comentarios"];
                break;
            case "empleados":
                $arr = ["empleado_ID","Nombre","Apellido","Inicial_del_segundo_apellido","Trabajo_ID","Jefe_ID","Fecha_contrato","Salario","Comision","Departamento_ID"];
                break;
            case "trabajos":
                $arr = ["Trabajo_ID","Funcion"];
                break;
            case "departamentos":
                $arr = ["departamento_ID","Nombre","Ubicacion_ID"];
                break;
            case "ubicaciones":
                $arr = ["Ubicacion_ID","GrupoRegional"];
                break;
            default:
                $arr = [""];
        }
        return $arr;
    }

    /**
     * Devuelve un array que contiene el nombre de las columnas dependiendo de la tabla indicada en el parametro
     * para imprimir el <select< para el filtro de valores.
     */
    function getColumnasFiltro($tabla){
        switch($tabla){
            case "clientes":
                $arr = ["nombre","Direccion","Ciudad","Estado","Codigo postal","Codigo de area","Telefono","Vendedor","Limite de credito","Comentarios"];
                break;
            case "empleados":
                $arr = ["Nombre","Apellido","Inicial del segundo apellido","Trabajo","Jefe","Fecha contrato","Salario","Comision","Departamento"];
                break;
            case "trabajos":
                $arr = ["Funcion"];
                break;
            case "departamentos":
                $arr = ["Nombre","Ubicacion"];
                break;
            case "ubicaciones":
                $arr = ["Grupo Regional"];
                break;
            default:
                $arr = [""];
        }
        return $arr;
    }
    
    /**
     * Recibe una tabla y una columna para sacar todos los valores y crea un <select> con dichos valores.
     */
    function crearSelect($tabla,$columna){
        $conexion = conectar("pufosa");
        $consulta = "select ".$columna." from ".$tabla." ORDER BY ".$columna." ASC";
        $registros = mysqli_query($conexion,$consulta) or die("Problemas con el select:".mysqli_error($conexion));
        echo '<select class="form-control" name="'.$tabla.$columna.'" style="min-width:50%;">';
        while($reg = mysqli_fetch_array($registros)){
            switch($tabla){
                case "cliente":
                    echo '<option value="'.$reg['CLIENTE_ID'].'" style="width:150px;" >'.$reg[$columna].'</option>';
                    break;
                case "empleados":
                    echo '<option value="'.$reg['empleado_ID'].'" style="width:150px;" >'.$reg[$columna].'</option>';
                    break;
                case "trabajos":
                    echo '<option value="'.$reg['Trabajo_ID'].'" style="width:150px;" >'.$reg[$columna].'</option>';
                    break;
                case "departamento":
                    echo '<option value="'.$reg['departamento_ID'].'" style="width:150px;" >'.$reg[$columna].'</option>';
                    break;
                case "ubicacion":
                    echo '<option value="'.$reg['Ubicacion_ID'].'" style="width:150px;" >'.$reg[$columna].'</option>';
                    break;
            }
        }
        echo "</select>";
        mysqli_close($conexion);
    }

    /**
     * Recibe una tabla ,una columna y una consulta para sacar todos los valores que cumplan
     * la condicion de la consulta y crea un <select> con dichos valores.
     */
    function crearSelectEspecifico($tabla,$columna,$consulta){
        $conexion = conectar("pufosa");
        $consulta = $consulta;
        $registros = mysqli_query($conexion,$consulta) or die("Problemas con el select:".mysqli_error($conexion));
        echo '<select class="form-control" name="'.$tabla.$columna.'" style="min-width:50%;">';
        while($reg = mysqli_fetch_array($registros)){
            switch($tabla){
                case "cliente":
                    echo '<option value="'.$reg['CLIENTE_ID'].'" style="width:150px;" >'.$reg[$columna].'</option>';
                    break;
                case "empleados":
                    echo '<option value="'.$reg['empleado_ID'].'" style="width:150px;" >'.$reg[$columna].'</option>';
                    break;
                case "trabajos":
                    echo '<option value="'.$reg['Trabajo_ID'].'" style="width:150px;" >'.$reg[$columna].'</option>';
                    break;
                case "departamento":
                    echo '<option value="'.$reg['departamento_ID'].'" style="width:150px;" >'.$reg[$columna].'</option>';
                    break;
                case "ubicacion":
                    echo '<option value="'.$reg['Ubicacion_ID'].'" style="width:150px;" >'.$reg[$columna].'</option>';
                    break;
            }
            
        }
        echo "</select>";
        mysqli_close($conexion);
    }

    /**
     * Recibe una tabla, una columna  y una cadena para sacar todos los valores
     * y crea un <select> con dichos valores, ademas, establece como selected al parametro pasado.
     */
    function crearSelected($tabla,$columna,$selected){
        $conexion = conectar("pufosa");
        $consulta = "select ".$columna." from ".$tabla." ORDER BY ".$columna." ASC";
        $registros = mysqli_query($conexion,$consulta) or die("Problemas con el select:".mysqli_error($conexion));
        echo '<select class="form-control form-control-lg" name="'.$tabla.$columna.'" style="min-width:50%;">';
        while($reg = mysqli_fetch_array($registros)){
            $nombre = $reg[$columna];
            if($nombre==$selected){
                switch($tabla){
                    case "cliente":
                        echo '<option value="'.$reg['CLIENTE_ID'].'" style="width:150px;" selected>'.$reg[$columna].'</option>';
                        break;
                    case "empleados":
                        echo '<option value="'.$reg['empleado_ID'].'" style="width:150px;" selected>'.$reg[$columna].'</option>';
                        break;
                    case "trabajos":
                        echo '<option value="'.$reg['Trabajo_ID'].'" style="width:150px;" selected>'.$reg[$columna].'</option>';
                        break;
                    case "departamento":
                        echo '<option value="'.$reg['departamento_ID'].'" style="width:150px;" selected>'.$reg[$columna].'</option>';
                        break;
                    case "ubicacion":
                        echo '<option value="'.$reg['Ubicacion_ID'].'" style="width:150px;" selected>'.$reg[$columna].'</option>';
                        break;
                }
            }else{
                switch($tabla){
                    case "cliente":
                        echo '<option value="'.$reg['CLIENTE_ID'].'" style="width:150px;" >'.$reg[$columna].'</option>';
                        break;
                    case "empleados":
                        echo '<option value="'.$reg['empleado_ID'].'" style="width:150px;" >'.$reg[$columna].'</option>';
                        break;
                    case "trabajo":
                        echo '<option value="'.$reg['Trabajo_ID'].'" style="width:150px;" >'.$reg[$columna].'</option>';
                        break;
                    case "departamento":
                        echo '<option value="'.$reg['departamento_ID'].'" style="width:150px;" >'.$reg[$columna].'</option>';
                        break;
                    case "ubicacion":
                        echo '<option value="'.$reg['Ubicacion_ID'].'" style="width:150px;" >'.$reg[$columna].'</option>';
                        break;
                }
            }
            
        }
        echo "</select>";
        mysqli_close($conexion);
    }

    /**
     * Recibe una tabla ,una columna y una consulta para sacar todos los valores que cumplan
     * la condicion de la consulta y crea un <select> con dichos valores.
     */
    function crearSelectedEspecifico($tabla,$columna,$consulta,$selected){
        $conexion = conectar("pufosa");
        $registros = mysqli_query($conexion,$consulta) or die("Problemas con el select:".mysqli_error($conexion));
        echo '<select class="form-control form-control-lg" name="'.$tabla.$columna.'" style="min-width:50%;">';
        while($reg = mysqli_fetch_array($registros)){
            if($reg[$columna]==$selected){
                switch($tabla){
                    case "cliente":
                        echo '<option value="'.$reg['CLIENTE_ID'].'" style="width:150px;" selected>'.$reg[$columna].'</option>';
                        break;
                    case "empleados":
                        echo '<option value="'.$reg['empleado_ID'].'" style="width:150px;" selected>'.$reg[$columna].'</option>';
                        break;
                    case "trabajos":
                        echo '<option value="'.$reg['Trabajo_ID'].'" style="width:150px;" selected>'.$reg[$columna].'</option>';
                        break;
                    case "departamento":
                        echo '<option value="'.$reg['departamento_ID'].'" style="width:150px;" selected>'.$reg[$columna].'</option>';
                        break;
                    case "ubicacion":
                        echo '<option value="'.$reg['Ubicacion_ID'].'" style="width:150px;" selected>'.$reg[$columna].'</option>';
                        echo '<script>console.log("'.$reg[$columna].'")</script>';
                        break;
                }
            }else{
                switch($tabla){
                    case "cliente":
                        echo '<option value="'.$reg['CLIENTE_ID'].'" style="width:150px;" >'.$reg[$columna].'</option>';
                        break;
                    case "empleados":
                        echo '<option value="'.$reg['empleado_ID'].'" style="width:150px;" >'.$reg[$columna].'</option>';
                        break;
                    case "trabajos":
                        echo '<option value="'.$reg['Trabajo_ID'].'" style="width:150px;" >'.$reg[$columna].'</option>';
                        break;
                    case "departamento":
                        echo '<option value="'.$reg['departamento_ID'].'" style="width:150px;" >'.$reg[$columna].'</option>';
                        break;
                    case "ubicacion":
                        echo '<option value="'.$reg['Ubicacion_ID'].'" style="width:150px;" >'.$reg[$columna].'</option>';
                        break;
                }
            }
            
        }
        echo "</select>";
        mysqli_close($conexion);
    }

    /**
     * Comprueba el privilegio que tiene el empleado pasado como parametro.
     *
     * @param [type] $conexion Variable que almacena la conexion.
     * @param [type] $id Id del empelado
     * @return number Numero que indica la prioridad del empleado sobre la aplicacion.
     */
    function comprobarAcceso($conexion,$id){
        $trabajo = mysqli_query($conexion,"select Trabajo_ID from empleados where empleado_ID = '".$id."'");
        $trabajo = mysqli_fetch_array($trabajo)['Trabajo_ID'];
        if($trabajo == '672'){
            return 2;
        }else if($trabajo == '671'){
            return 1;
        }else{
            return 0;
        }
    }
    
?>