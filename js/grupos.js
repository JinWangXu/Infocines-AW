
function accionGrupo(grupo, user, accion, rol) {
	
	$.post({

		url: "accionesGrupo.php",
		data: {grupo:grupo, user:user, accion:accion,rol:rol},
		dataType:"JSON",
	  
		
	}).done(function(respuesta){
		
		if (respuesta.exito == 1){
			//alert(respuesta.mensaje);
			//$("#").html(respuesta);
			//alert(respuesta.tipo);
			if(respuesta.tipo == "n"){
				alert(respuesta.mensaje);
				location.replace("foro_grupos.php");

			}else if(respuesta.tipo == "x"){
				alert(respuesta.mensaje);
				location.reload();

			}else if(respuesta.tipo == "w"){
				crearNotificacion("crear", respuesta.user, respuesta.info, "i");
				alert(respuesta.mensaje);	
				location.replace("foro_grupos.php");

			}else if(respuesta.tipo == "a"){	
				alert(respuesta.mensaje);	
				location.reload();
				
			}else if(respuesta.tipo == "b"){
				crearNotificacion("crear", respuesta.user, respuesta.info, "i");
				alert(respuesta.mensaje);
				location.replace("GrupoConcreto.php?id="+respuesta.grupo);
			}else{

				crearNotificacion("crear", respuesta.user, respuesta.info, respuesta.tipo);
				

				alert(respuesta.mensaje);
				location.replace("GrupoConcreto.php?id="+respuesta.grupo);
			}
			
		}
		else{
			alert("error");
		}
		
		
	});
		
 
}

function listarGrupos(){
	$.post({

        url: "accionesGrupo.php",
        data: {accion:"listarPublico"},

            
    }).done(function(respuesta){
		$("#mostrarGrupos").html(respuesta);
		
      
    });
}

function borrarTema(idTema,idGrupo){
	$.post({

        url: "accionesGrupo.php",
        data: {grupo:idTema, user: idGrupo, accion:"borrarTema" },

            
    }).done(function(respuesta){
		alert("Tema borrado");
		location.replace("foro_grupos.php");
		
      
    });
}

function buscarGrupo(id){
	$.post({

        url: "accionesGrupo.php",
        data: {grupo:id, accion:"mostrarBuscado"},

            
    }).done(function(respuesta){
		$("#mostrarGrupoBuscado").html(respuesta);
		
      
    });
}

$(document).ready(function() {//Cuando el documento este listo
	listarGrupos();
});

