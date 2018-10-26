<?php

    function printBarra(){
        echo '<div class="logout-nav">
            <img src="img/logo2.png" alt="logo de la empresa">
            <a href="logout.php">Cerrar Sesión</a>
        </div>';
    }

    /**
     * Funcion que te conecta a una determinada base de datos con el ususario root.
     */
    function conectar($base){
        $conexion = mysqli_connect("localhost","root","",$base) or
            die("Problemas de conexión");
        return $conexion;
    }
    
    /**
     * Escribe un mensaje en el fichero log.txt
     */
    function escribirEnLog($mensaje){
        $fichero = fopen("log.txt","a");
        fputs($fichero,date("Y-m-d H:i:s")." : ".$mensaje." |");
        fputs($fichero,"\n");
        fclose($fichero);
    }

    /**
     * Imprime una tabla dependiendo del valor del parametro.
     */
    function imprimirTabla($tabla,$select){
        $conexion = conectar("pufosa");
        echo '<div class="table-container">';
        switch($tabla){
            case "cli":
                $registros = mysqli_query($conexion,$select) or die("Problemas en el select");
                echo "<table border=3 style='border-collapse: collapse'>";
                echo //"<th>Cliente_ID</th>
                    "<th>Nombre</th>
                    <th>Direccion</th>
                    <th>Ciudad</th>
                    <th>Estado</th>
                    <th>Codigo Postal</th>
                    <th>Codigo de Area</th>
                    <th>Telefono</th>
                    <th>Limite_de_credito</th>";
                while($reg = mysqli_fetch_array($registros)){
                    echo "<tr>";
                    echo //"<td>".$reg['CLIENTE_ID']."</td>
                        "<td>".$reg['nombre']."</td>
                        <td>".$reg['Direccion']."</td>
                        <td>".$reg['Ciudad']."</td>
                        <td>".$reg['Estado']."</td>
                        <td>".$reg['CodigoPostal']."</td>
                        <td>".$reg['CodigoDeArea']."</td>
                        <td>".$reg['Telefono']."</td>
                        <td>".$reg['Limite_De_Credito']."</td>";
                    echo "</tr>";
                }
                echo "</table>";
                break;
            case "emp":
                $registros = mysqli_query($conexion,$select) or die("Problemas en el select");
                echo "<table border=3 style='border-collapse: collapse'>";
                echo "<th>Empleado_ID</th>
                    <th>Apellido</th>
                    <th>Nombre</th>
                    <th>Inicial del segundo apellido</th>
                    <th>Trabajo_ID</th>
                    <th>Jefe_ID</th>
                    <th>Fecha_contrato</th>
                    <th>Salario</th>
                    <th>Comision</th>
                    <th>Departamento_ID</th>";
                while($reg = mysqli_fetch_array($registros)){
                    echo "<tr>";
                    echo "<td>".$reg['empleado_ID']."</td>
                        <td>".$reg['Apellido']."</td>
                        <td>".$reg['Nombre']."</td>
                        <td>".$reg['Inicial_del_segundo_apellido']."</td>
                        <td>".$reg['Trabajo_ID']."</td>
                        <td>".$reg['Jefe_ID']."</td>
                        <td>".$reg['Fecha_contrato']."</td>
                        <td>".$reg['Salario']."</td>
                        <td>".$reg['Comision']."</td>
                        <td>".$reg['Departamento_ID']."</td>";
                    echo "</tr>";
                }
                echo "</table>";
                break;
            case "tra":
                $registros = mysqli_query($conexion,$select) or die("Problemas en el select");
                echo "<table border=3 style='border-collapse: collapse'>";
                echo "<th>Trabajo_ID</th>
                    <th>Función</th>";
                while($reg = mysqli_fetch_array($registros)){
                    echo "<tr>";
                    echo "<td>".$reg['Trabajo_ID']."</td>
                        <td>".$reg['Funcion']."</td>";
                    echo "</tr>";
                }
                echo "</table>";
                break;
            case "dep":
                $registros = mysqli_query($conexion,$select) or die("Problemas en el select");
                echo "<table border=3 style='border-collapse: collapse'>";
                echo "<th>departamento_ID</th>
                    <th>Nombre</th>
                    <th>Ubicacion_ID</th>";
                while($reg = mysqli_fetch_array($registros)){
                    echo "<tr>";
                    echo "<td>".$reg['departamento_ID']."</td>
                        <td>".$reg['Nombre']."</td>
                        <td>".$reg['Ubicacion_ID']."</td>";
                    echo "</tr>";
                }
                echo "</table>";
                break;
            case "ubi":
                $registros = mysqli_query($conexion,$select) or die("Problemas en el select");
                echo "<table border=3 style='border-collapse: collapse'>";
                echo "<th>Ubicacion_ID</th>
                    <th>Grupo regional</th>";
                while($reg = mysqli_fetch_array($registros)){
                    echo "<tr>";
                    echo "<td>".$reg['Ubicacion_ID']."</td>
                        <td>".$reg['GrupoRegional']."</td>";
                    echo "</tr>";
                }
                echo "</table>";
                break;
        }
        echo '</div>';
    }

    /**
     * Muestra la opcion de añadir un determiando cliente a una 
     */
    function añadir($opcion){
        echo '<div class="formulario">';
        echo '<form action="añadir.php" method="GET">';
        $campos = getHeaders($opcion);
        switch($opcion){
            case "cli";
                echo "<h2>Añadir cliente</h2>";
                for($i = 1; $i< sizeOf($campos); $i++){
                    if($campos[$i]== "Vendedor_ID"){
                        echo "Vendedor";
                        crearSelect("empleados","empleado_ID");
                        echo "<br>";
                        continue;
                    }else{
                        echo ucfirst($campos[$i]);
                    }
                    echo '<input type="text" name='.$campos[$i].' required><br>';
                }
                break;
            case "emp";
                echo "<h2>Añadir empleado</h2>";
                for($i = 1; $i< sizeOf($campos); $i++){
                    if($campos[$i] == "Trabajo_ID"){
                        echo "Trabajo";
                        crearSelect("trabajos","Funcion");
                        echo "<br>";
                        continue;
                    }
                    elseif($campos[$i] == "Departamento_ID"){
                        echo "Departamento";
                        crearSelect("departamento","departamento_ID");
                        echo "<br>";
                        continue;
                    }else{
                        echo $campos[$i];
                    }
                    echo '<input type="text" name='.$campos[$i].' required><br>';
                }
                break;
            case "tra";
                echo "<h2>Añadir empleado</h2>";
                for($i = 0; $i< sizeOf($campos); $i++){
                    echo $campos[$i];
                    echo '<input type="text" name='.$campos[$i].' required><br>';
                }
                break;
            case "dep";
                echo "<h2>Añadir empleado</h2>";
                for($i = 0; $i< sizeOf($campos); $i++){
                    if($campos[$i]== "Ubicacion_ID"){
                        echo "Grupo regional";
                        crearSelect("ubicacion","GrupoRegional");
                        echo "<br>";
                        continue;
                    }else{
                        echo $campos[$i];
                    }
                    echo '<input type="text" name='.$campos[$i].' required><br>';
                }
                break;
            case "ubi";
                echo "<h2>Añadir empleado</h2>";
                for($i = 0; $i< sizeOf($campos); $i++){
                    echo $campos[$i];
                    echo '<input type="text" name='.$campos[$i].' required><br>';
                }
                break;
        }
        echo "<hr>";
        echo '<input type="hidden" name="añadido" value="'.$opcion.'">';
        echo '<input type="submit" value="Añadir">';
        echo '</form>';
        echo '</div>';
    }

    /**
     * Añade la opcion de filtrado para la consulta de tablas
     * Valores posibles => {cli, emp, tra, dep, ubi}
     */
    function añadirFiltrado($opcion){
        $conexion = conectar("pufosa");
        $filtros = getHeaders($opcion);
        echo '<div class="table-container">';
        echo '<form method="GET" action="ver.php"';
        echo "<span> Filtrar por: </span>";
        echo '<select name="filtro">';
        for($i = 0; $i < sizeOf($filtros); $i++){
            echo '<option value="'.$filtros[$i].'">'.ucfirst($filtros[$i]).'</option>';
        }
        echo "</select>&nbsp;";
        echo '<input type="text" name="valor" value="" required> ';
        echo '<input type="submit" value="Filtrar">';
        echo '<input type="hidden" name="opcion" value='.$opcion.'>';
        echo "</form>";
        echo '</div>';
        echo "<hr>";
    }

    /**
     * Array que contiene el nombre de las columnas dependiendo de la tabla indicada en el parametro
     * Valores posibles => {cli, emp, tra, dep, ubi}
     */
    function getHeaders($tabla){
        switch($tabla){
            case "cli":
                $arr = ["nombre","Direccion","Ciudad","Estado","CodigoPostal","CodigoDeArea","Telefono","Vendedor_ID","Limite_De_Credito"];
                break;
            case "emp":
                $arr = ["Apellido","Nombre","Inicial_del_segundo_apellido","Trabajo_ID","Jefe_ID","Fecha_contratacion","Salario","Comision","Departamento_ID"];
                break;
            case "tra":
                $arr = ["Funcion"];
                break;
            case "dep":
                $arr = ["Nombre","Ubicacion_ID"];
                break;
            case "ubi":
                $arr = ["GrupoRegional"];
                break;
            default:
                $arr[""];
        }
        return $arr;
    }

    /**
     * Recibe una tabla y una columna para sacar valores y crea a un <select>
     */
    function crearSelect($tabla,$campo){
        $conexion = conectar("pufosa");
        $consulta = "select distinct(".$campo.") from ".$tabla." ORDER BY ".$campo." ASC";
        $registros = mysqli_query($conexion,$consulta) or die("Problemas con el select:".mysqli_error($conexion));
        echo '<select name="'.$campo.'" style="width:100px;">';
        while($reg = mysqli_fetch_array($registros)){
            echo '<option value='.$reg[$campo].'>'.$reg[$campo].'</option>';
        }
        echo "</select>";
    }

    function select($consulta){
        $conexion = conectar("pufosa");
        $consulta = mysqli_query($conexion,$consulta) or die("Problemas con el select: ".mysqli_error($conexion));
        return $consulta;
    }

    function consulta($consulta){
        $conexion = conectar("pufosa");
        mysqli_query($conexion,$consulta) or die("Problemas con el select: ".mysqli_error($conexion));
    }
?>