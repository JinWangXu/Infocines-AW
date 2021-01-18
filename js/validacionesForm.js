
function correoValido(correo){
    var arroba = '@';
    var punto = '.'; 
    var valido = false;
    var indiceArroba = correo.indexOf(arroba);

    if(indiceArroba > 0 ){
       valido = true;
    }
    correo = correo.substring(indiceArroba, correo.length);
    var indicePunto = correo.indexOf(punto);
    if(indicePunto > 0){
        valido = true;
    }
    else{
        valido = false;
    }
    return valido;
}

function usuarioExiste(data, status){
    if(data == "existe"){
        $("#okUsuario").hide();
        $("#noUsuario").show();      
        alert("El usuario ya existe");
    }
    else{
        $("#noUsuario").hide();
        $("#okUsuario").show();  
    }
}

$(document).ready(function() {

    $("#okCorreo").hide();
    $("#okUsuario").hide();

    $("#correo").change(function(){
    if (correoValido($("#correo").val())){
        $("#noCorreo").hide();
        $("#okCorreo").show();
    } 
    else {
        $("#noCorreo").show();
        $("#okCorreo").hide();
    }
    });

    $("#nick").change(function(){
        var url="comprobarUsuario.php?user=" + $("#nick").val();
        $.get(url,usuarioExiste);
       });
});