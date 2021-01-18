$(document).ready(function () {

    $.post({
        url: "recomendaciones.php",

        data:{peticion : 'mostrarUsuarios', id : ''},
    }).done(function (codigo) {
        $("#resultadoBusqueda").html(codigo);
        
    });

    $("#botonRecomendar").click(function () {
        $(".fondoRecomendaciones").show();
    })

    $("#botonCerrarRecomendaciones").click(function () {
        $(".fondoRecomendaciones").hide();
    })

    //Si se pulsa fuera del formulario de recomendaciones se cierra

    $(window).click(function (e) {
        if (e.target.className == "fondoRecomendaciones") {
            $(".fondoRecomendaciones").hide();
        }
    })

    //Buscador de usuarios para recomendar pelis
      
      $("#buscador").keyup(function () {
            var texto = $(this).val();
           
                $.post({
                    url: "recomendaciones.php",
            
                    data:{peticion : 'mostrarUsuarios', id : texto},
                }).done(function (codigo) {
                    $("#resultadoBusqueda").html(codigo);
                    
                });
            
        })

    //Buscador pelis
    $("#tituloPeliBuscar").keyup(function () {
        buscarPeli();        
    })

    $("#anioPeliBuscar").change(function () {
        buscarPeli();        
    })

    $("#generoPeliBuscar").change(function () {
        buscarPeli();        
    })

    $("#directorPeliBuscar").keyup(function () {
        buscarPeli();        
    })

    $("#valoracionPeliBuscar").change(function () {
        buscarPeli();        
    })

    $('#formComentario').on('submit', function (event) {
        event.preventDefault();
        var datosForm = $(this).serialize();
        $.ajax({
            url:"comentario.php",
            method:"POST",
            data:datosForm,
            dataType:"JSON",
            success:function (data) {
                if (data.error != '') {
                    $('#formComentario')[0].reset();
                    $('#idComentario').val("0");
                    $('#leyenda').text("Comentario");
                    $('#mensajeComentario').html(data.error);
                    cargarComentario();
                }
            },
        })
    });
});

function procesar(id, pedido) {
    $.post({
        url: "recomendaciones.php",

        data:{id : id, peticion : pedido},
        dataType: "JSON"
    }).done(function (json) {
        if (json.exito != 0) {
            

            var texto = $("#buscador").val();
           
                $.post({
                    url: "recomendaciones.php",
            
                    data:{peticion : 'mostrarUsuarios', id : texto},
                }).done(function (codigo) {
                    $("#resultadoBusqueda").html(codigo);
                    
                });

            alert(json.mensaje);
        }
        else{
            alert(json.mensaje);
        }
        
    });
}

function buscarPeli() {
    var titulo = $("#tituloPeliBuscar").val();
    var anio = $("#anioPeliBuscar").val();
    var genero = $("#generoPeliBuscar").val();
    var director = $("#directorPeliBuscar").val();
    var valoracion = $("#valoracionPeliBuscar").val();
    $.post({
        url: "buscarPeli.php",

        data:{titulo : titulo, anio : anio, genero : genero, director : director, valoracion : valoracion}
    }).done(function (codigo) {
        $("#peliculasMostradas").html(codigo);
    });
}

function getUrlVars() {
    var vars = {};
    var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m,key,value) {
        vars[key] = value;
    });
    return vars;
}

function getUrlParam(parameter, defaultvalue){
    var urlparameter = defaultvalue;
    if(window.location.href.indexOf(parameter) > -1){
        urlparameter = getUrlVars()[parameter];
        }
    return urlparameter;
}

// @ts-check
function cargarComentario() {
    var accion = 'buscarComentario';
    var prueba = {accionComentario : accion };
    //alert(typeof(prueba));
    $.ajax({
        url:"comentario.php",
        method:"POST",
        data: prueba,
        //dataType:"JSON",
        success:function (data) {
            $('#mostrarComentario').html(data);
        }
    })
    
}

$(document).on('click', '.responder', function () {
    var idComentario = $(this).attr("id");
    $('#idComentario').val(idComentario);
    $('#leyenda').text("Respuesta");
    $('#texto').focus();
})

$(function() {
    $('.rate input').on('click', function(){
        var ratingNum = $(this).val();


        $.ajax({
             url: "valoracion.php",
            method: "POST",
            dataType: "JSON",
            data: { 
                ratingNum: ratingNum,

                }, success: function(resp) {
                if(resp.status == 1){
                    $('#valoracionMedia').html(resp.data);
                    alert('Gracias! Has valorado '+ratingNum+'');
                }
                if(resp.status == 2){
                    $('#valoracionMedia').html(resp.data);
                    alert('Su valoración se ha cambiado a '+ratingNum+'');
                }
                if(resp.status == 3){
                    alert('No estás registrado, no puedes valorar');
                }
                }
        });   
    });
});


var count = 0;
$(".tema").click(function() {
    count += 1;
    $( "#modoOscuro" ).toggleClass( "black" );
    $( "#verPContainer").toggleClass("black2");
    if(count % 2 == 1){
    $( "#verPContainer").css('background', '#000000').finish();
    }
    else{
     $( "#verPContainer").css('background', '#f2f2f2').finish();
    }
    $(".tit").toggleClass("verPMO");
    $(".tema").toggleClass("temaNoc");
});

$(function() {
    $('#botonFav').on('click', function(){


        $.ajax({
             url: "addFavorito.php",
            method: "POST",
            dataType: "JSON",
            success: function(resp) {
					if(resp.state == 1){
                        alert('Pelicula añadida a favoritos');
                        $('#botonFav').html("Eliminar de favoritos &#128151;");
					}
					if(resp.state == 2){
                        alert('Pelicula eliminada de favoritos');
                        $('#botonFav').html("Añadir a favoritos &#128151;");
					}
                }
        });   
    });
}); 