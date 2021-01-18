
$(document).ready(function () {
    listar();
    
});
function listar() {
    //lista los amigos del usuario 
    $.post({
        url: "recomendaciones.php",

        data:{peticion : 'mostrarPeliculas'}
        
    }).done(function (codigo) {
        $("#contenedorPelis").html(codigo);
    });
}


function procesar(id, pedido) {
    $.post({
        url: "recomendaciones.php",

        data:{id : id, peticion : pedido},
        dataType: "JSON"
    }).done(function (json) {
        if (json.exito != 0) {
            listar();
            alert(json.mensaje);
        }
        else{
            alert(json.mensaje);
        }
        
    });
}
