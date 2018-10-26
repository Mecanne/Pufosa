<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <?php
        $fichero = fopen("log.txt","r") or
            die("El fichero no se ha podido abrir.");
        while(!feof($fichero)){
            $linea = fgets($fichero);
            $lineaSalto = nl2br($linea);
            echo $lineaSalto;
        }
    ?>
</body>
</html>