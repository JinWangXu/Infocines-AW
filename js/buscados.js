function accionGrupo(grupo, user, accion, rol) {
	
	$.post({

		url: "accionesGrupo.php",
		data: {grupo:grupo, user:user, accion:accion,rol:rol},
		dataType:"JSON",
	  
		
	}).done(function(respuesta){
		
		if (respuesta.exito == 1){
		    if(respuesta.tipo == "x"){
				alert(respuesta.mensaje);
				location.reload();
			}
			
		}
		else{
			alert("error");
		}
		
		
	});
		
 
}



function listarBuscados(nombre){
    $.post({

        url: "accionesGrupo.php",
        data: {grupo:nombre, accion:"mostrarBuscado"},

            
    }).done(function(respuesta){
		$("#mostrarGrupoBuscado").html(respuesta);
		
      
    });
}


function start(nombre)
{
    return function()
    {
       listarBuscados(nombre);
    }
}

