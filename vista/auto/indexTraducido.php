<?php

include_once "../estructura/cabeceraBT.php";
include_once "../../utiles/vendor/autoload.php";
$datos = data_submitted();
$datos['accion']="listar";
include_once("accion.php");

// Ruta del archivo HTML que se desea traducir
$rutaHtml = 'index.php';

// Extraer textos del HTML de diferentes secciones
$textosMain = array_merge(
    extraerTexto($rutaHtml, 'h3'),
    extraerTexto($rutaHtml, '.col-md-12.float-right', 'a'),
    extraerTexto($rutaHtml, 'thead', 'th'),
    extraerTexto($rutaHtml, 'td', '.btn')
);

// Se define el idioma de origen
$idiomaOrigen = 'es';
// Se traducen los textos extraídos
$textosTraducidos = traducirTextos($textosMain, $idiomaOrigen, $idiomaSeleccionado);
?>

<link rel="stylesheet" href="../css/delahome.css">

<h3><?php echo $textosTraducidos[0]; ?></h3>


<div class="row float-left">
    <div class="col-md-12 float-left">
      <?php 
      if(isset($datos) && isset($datos['msg']) && $datos['msg']!=null) {
        echo $datos['msg'];
      }
     ?>
    </div>
</div>

<div class="row float-right">
    <div class="col-md-12 float-right">
        <a class="btn btn-success" role="button" href="editar.php?accion=nuevo"><?php echo $textosTraducidos[1]; ?></a>
    </div>
</div>


<div class="table-responsive">
    <table class="table table-striped table-sm">
        <thead>
        <tr>
            <th scope="col"><?php echo $textosTraducidos[2]; ?></th>
            <th scope="col"><?php echo $textosTraducidos[3]; ?></th>
            <th scope="col"><?php echo $textosTraducidos[4]; ?></th>
            <th scope="col"><?php echo $textosTraducidos[5]; ?></th>
            <th scope="col"><?php echo $textosTraducidos[6]; ?></th>
            <th scope="col"><?php echo $textosTraducidos[7]; ?></th>
        </tr>
        </thead>
        <tbody>

<?php
 if(count($lista)>0){
    foreach ($lista as $uno) {
        echo '<tr><td>'. $uno['patente'] .'</td>';
        echo '<td>'.$uno['marca'].'</td>';
        echo '<td>'.$uno['modelo'].'</td>';
        echo '<td>'.$uno['anio'].'</td>';
        echo '<td>'.$uno['dni_usuario'].'</td>';
        echo '<td><a class="btn btn-info" role="button" href="editar.php?accion=editar&patente='.$uno['patente'].'">'. $textosTraducidos[8] .'</a>';
        echo '<a class="btn btn-primary" role="button" href="editar.php?accion=borrar&patente='.$uno['patente'].'">'. $textosTraducidos[9] .'</a></td></tr>';
	}
}
?>
        </tbody>
    </table>
</div>


<?php
    include_once "../estructura/pieBT.php";
?>