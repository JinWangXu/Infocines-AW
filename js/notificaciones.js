function accionNotificacion(id, accion) {

	$.post({
        url: "accionesNotificaciones.php",
        data: {id:id, accion:accion},
        dataType:"JSON",
    }).done(function(respuesta){
        if (respuesta.exito == 1){
           // alert(respuesta.mensaje);
            listarNotificaciones();
        }  
    });
		
}

function crearNotificacion(accion, user, info, tipo) {
	$.post({
        url: "accionesNotificaciones.php",
        data: {accion:accion, user:user, info:info, tipo:tipo},
        dataType:"JSON",   
    }).done(function(respuesta){     
    });
		
}

function listarNotificaciones(){
    $.post({
        url: "accionesNotificaciones.php",
        data: {accion:"listar"},   
    }).done(function(respuesta){
        $("#mostrarNotificaciones").html(respuesta);
            $.post({
                url: "accionesNotificaciones.php",
                data: {accion:"getContador"},
                dataType:"JSON",     
            }).done(function(respuesta){
                
            if(respuesta.contador != 0){
                $("#campana").html('<img src="media/notificaciones.png" alt="campana" id="notificacion"><span class="badge">'+respuesta.contador+'</span>');
            } else{
                $("#campana").html('<img src="media/notificaciones.png" alt="campana" id="notificacion">');
            }
        });
    });
}


$(document).ready(function(){
    $("#borrarAll").onclick =function(){
        accionNotificacion(0, "deleteAllUser");
    }
    listarNotificaciones();
});

