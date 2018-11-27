function ocultar(id) {
    setTimeout(function (){
        document.getElementById(id).style.display = "none";
    },3000);
}
function mostrar(id) {
    document.getElementById(id).style.display = "block";
}


