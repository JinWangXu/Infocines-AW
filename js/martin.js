
$(document).ready(function() {//Cuando el documento este listo
	

});

function accionGrupo(grupo, user, accion, rol) {
	
	$.post({

		url: "accionesGrupo.php",
		data: {grupo:grupo, user:user, accion:accion,rol:rol},
		dataType:"JSON",
	  
		
	}).done(function(respuesta){
		
		if (respuesta.exito == 1){
			
			if(respuesta.tipo != ""){
				crearNotificacion("crear", respuesta.user, respuesta.info, respuesta.tipo);
			}
			
		}
		else{
			alert(respuesta.mensaje);
		}
		
		
	});
		
		
	
	
	
 
}