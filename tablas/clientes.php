<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Page Title</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../css/menu.css">
    <link rel="stylesheet" href="../css/tabla.css">
    <script src="main.js"></script>
    <style>
        #myBtn {
        display: none; /* Hidden by default */
        position: fixed; /* Fixed/sticky position */
        bottom: 20px; /* Place the button at the bottom of the page */
        right: 30px; /* Place the button 30px from the right */
        z-index: 99; /* Make sure it does not overlap */
        border: none; /* Remove borders */
        outline: none; /* Remove outline */
        background-color: black; /* Set a background color */
        color: white; /* Text color */
        cursor: pointer; /* Add a mouse pointer on hover */
        padding: 15px; /* Some padding */
        border-radius: 10px; /* Rounded corners */
        font-size: 18px; /* Increase font size */
    }

    #myBtn:hover {
        background-color: #555; /* Add a dark-grey background on hover */
    }
    </style>
</head>
<body>
    <?php
        session_start();
        require_once("../funciones.php");
        if(isset($_SESSION['admin'])) imprimirBarraTabla(1);
        else imprimirBarraTabla(0);

    ?>
    <div class="box">
        <button onclick="displayAdd('add')" class="actionBtn">Añadir cliente</button>
        <button onclick="displayAdd('add')" class="actionBtn">Modificar cliente</button>
        <button onclick="displayAdd('add')" class="actionBtn">Borrar cliente</button>
        
        
    <?php
        if(isset($_REQUEST['addsuccess'])){}
        añadirModal('cli');
        añadirFiltrado("cli");
        if(isset($_REQUEST['filtro'])){
            if($_REQUEST['filtro'] == 'Vendedor'){
                imprimirTabla("cli","select * from cliente,empleados where Vendedor_ID = empleado_ID and (empleados.Nombre like '%".$_REQUEST['valor']."%' OR empleados.Apellido like '%".$_REQUEST['valor']."%')");
            }else{
                imprimirTabla("cli","select * from cliente where ".$_REQUEST['filtro']." like '%".$_REQUEST['valor']."%'");
            }
            echo '<a href="clientes.php">Restaurar</a>';
        }else{
            imprimirTabla("cli","select * from cliente");
        }
    ?>
    </div>
    <button onclick="topFunction()" id="myBtn" title="Subir">^</button> 
<script>
    function displayAdd(id) {
    var x = document.getElementById(id);
    if (x.style.display === "block") {
        x.style.display = "none";
    } else {
        x.style.display = "block";
    }

    // Get the modal
    var modal = document.getElementById('add');

    // Recoge el boton que cierra el formulario
    var btn = document.getElementById("boton");

    // Cuando presonas el boton, el formulario se esconde.
    btn.onclick = function() {
        modal.style.display = "none";
    }
    // Si se presiona la pantalla presionando el 
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    } 
}
// When the user scrolls down 20px from the top of the document, show the button
window.onscroll = function() {scrollFunction()};

function scrollFunction() {
    if (document.body.scrollTop > 80 || document.documentElement.scrollTop > 80) {
        document.getElementById("myBtn").style.display = "block";
    } else {
        document.getElementById("myBtn").style.display = "none";
    }
}

// When the user clicks on the button, scroll to the top of the document
function topFunction() {
    document.body.scrollTop = 0; // For Safari
    document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE and Opera
} 
</script>
</body>
</html>