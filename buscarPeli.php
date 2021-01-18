<?php

use es\fdi\ucm\aw\DAOGenero;
use es\fdi\ucm\aw\DAOPelicula;

require_once __DIR__.'/includes/config.php';

    $titulo = isset($_POST['titulo']) ? htmlspecialchars(trim(strip_tags($_POST['titulo']))) : null;
    $anio = isset($_POST['anio']) ? htmlspecialchars(trim(strip_tags($_POST['anio']))) : null;
    $genero = isset($_POST['genero']) ? htmlspecialchars(trim(strip_tags($_POST['genero']))) : null;
    $director = isset($_POST['director']) ? htmlspecialchars(trim(strip_tags($_POST['director']))) : null;
    $valoracion = isset($_POST['valoracion']) ? htmlspecialchars(trim(strip_tags($_POST['valoracion']))) : null;

    if ($anio == "0") {
        $anio = null;
    }

    if ($valoracion == "0") {
        $valoracion = null;
    }

    $pelis = DAOPelicula::listarBusqueda($titulo, $anio, $director, $valoracion);

    if (isset($pelis)) {
            $generoSet = false;

            if ( $genero != "0"){
                $generoSet = true;
            }
            else{
                $listaGenero = DAOGenero::list();
            }
        
            if ($generoSet) {
                $toGenero = DAOGenero::read(intval($genero));
                $cabecera = '<div class="grid-container">
                        <div class= "item1"> '.$toGenero->getTipo().' </div>	
                        <div class="grid-subContainer">';
                    $i = 0;
                    $stringPelis = '';
                    foreach ($pelis as $peli) {
                        if(DAOGenero::comprobarGeneroPelicula($toGenero->getIdGenero(), $peli->getIdPelicula())){
                            $stringPelis .= '<div class="grid-sub2Container">  <div class="tituloPelicula"> '. $peli->getTitulo().' </div>  <div class="imagenPelicula"> <a class="nom" href="peliculaConcreta.php?id='.$peli->getIdPelicula().'"> <img src=' .$peli->getUrlImagen().' alt="imagen ' . $peli->getIdPelicula().'" id="widthImg""> </a> </div> </div>';	
                            $i = $i + 1;
                        }
                        
                        }
                        
                    
                    if($i>0){
                        echo $cabecera . $stringPelis;
                    }
                    else{
                        echo '<div class="grid-container">
                        <div class= "item1"> No se han encontrado películas </div>	
                        <div class="grid-subContainer">';
                    }
                        echo '</div> </div>';
            }
            else{
                $encontrada = false;
                foreach ($listaGenero as $genero) {
                    $cabecera = '<div class="grid-container">
                        <div class= "item1"> '.$genero->getTipo().' </div>	
                        <div class="grid-subContainer">';
                    $i = 0;
                    $stringPelis = '';
                    foreach ($pelis as $peli) {
                        if(DAOGenero::comprobarGeneroPelicula($genero->getIdGenero(), $peli->getIdPelicula())){
                            $stringPelis .= '<div class="grid-sub2Container">  <div class="tituloPelicula"> '. $peli->getTitulo().' </div>  <div class="imagenPelicula"> <a class="nom" href="peliculaConcreta.php?id='.$peli->getIdPelicula().'"> <img src=' .$peli->getUrlImagen().' alt="imagen ' . $peli->getIdPelicula().'" id="widthImg""> </a> </div> </div>';	
                            $i = $i + 1;
                            $encontrada = true;
                        }
                        
                        }
                        
                    
                    if($i>0){
                        echo $cabecera . $stringPelis;
                        echo '</div> </div>';
                    }
                }
        
                if(!$encontrada){
                    echo '<div class="grid-container">
                    <div class= "item1"> No se han encontrado películas </div>	
                    <div class="grid-subContainer">';
                }
            }
        
    } else {
        echo '<p>No existen películas con estas características</p>';
    }
    
?>