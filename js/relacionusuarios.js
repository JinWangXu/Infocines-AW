$(document).ready(function () {
    listar();

    $("#botonAdd").click(function () {
        $.post({
            url: "eventosBotonesAmigos.php",
    
            data:{peticion : 'add'},
        }).done(function (codigo) {
            $("#lista").html(codigo);
            
            $("#buscador").keyup(function () {
                var texto = $(this).val();
                if (texto != '') {
                    $.post({
                        url: "relacionusuarios.php",
                
                        data:{peticion : 'buscarAmigos', id : texto},
                    }).done(function (codigo) {
                        $("#resultadoBusqueda").html(codigo);
                        
                    });
                }
                else{
                    $('#resultadoBusqueda').html('<p>Introduce un apodo de usuario para buscar</p>');
                }
            })

        });
    })

    $("#botonVer").click(function () {
        listar('F');
    })

    $("#botonPeticiones").click(function () {
        listar('P');
    })

    $("#botonBloqueados").click(function () {
        listar('B');
    })

});
function listar(estado) {
    //lista los amigos del usuario 
    $.post({
        url: "relacionusuarios.php",

        data:{peticion : 'mostrarUsuarios', id : estado}
        
    }).done(function (codigo) {
        $("#lista").html(codigo);
    });
}
//id del usuario elegido y pedido es la peticion al php
function procesar(id, pedido) {
    $.post({
        url: "relacionusuarios.php",

        data:{id : id, peticion : pedido},
        dataType: "JSON"
    }).done(function (json) {
        if (json.exito != 0) {
            $("#lista").html(json.mensaje);
        }
        else{
            alert(json.mensaje);
        }
        
    });
}


