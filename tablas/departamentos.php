<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Page Title</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="main.js"></script>
    <style>
        table {
            border: solid 1px white;
            border-collapse: collapse;
            width: 100%;
        }

        table *{
            border: none;
            text-align: center;
        }
        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        
        th{background-color: #a5d2ff;}
        table tr:nth-child(odd) {background-color:#f5f5f5;}
    </style>
</head>
<body>
    <?php
        require_once("../funciones.php");

        añadirFiltrado("dep");
        if(isset($_REQUEST['filtro'])){
            imprimirTabla("dep","select * from departamentos where ".$_REQUEST['filtro']." = '".$_REQUEST['valor']."'");
            echo '<a href="departamentos.php">Restaurar</a>';
        }else{
            imprimirTabla("dep","select * from departamentos");
        }
    ?>
</body>
</html>