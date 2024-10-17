<?php

//session_start();

include_once "../estructura/cabeceraBT.php";
include_once "../../utiles/vendor/autoload.php";
use DiDom\Document;

// Ruta del archivo HTML que se desea traducir
$rutaHtml = 'index.php';

// Extraer textos del HTML de diferentes secciones
$textosMain = array_merge(
    extraerTexto($rutaHtml, '.heading0'),
    extraerTexto($rutaHtml, '.heading1'),
    extraerTexto($rutaHtml, '.heading1a'),
    extraerTexto($rutaHtml, '.content')
);

// Se define el idioma de origen
$idiomaOrigen = 'es';
// Se traducen los textos extraídos
$textosTraducidos = traducirTextos($textosMain, $idiomaOrigen, $idiomaSeleccionado);

$documento = new Document(file_get_contents($rutaHtml));

// Se define la frase clave dependiendo del idioma de destino
if ($idiomaSeleccionado == 'en') {
    $fraseClave = "The script for its creation can be downloaded from";
} else if ($idiomaSeleccionado == 'fr') {
    $fraseClave = "Le script pour sa création peut être téléchargé depuis";
} else {
    $fraseClave = "Das Skript zur Erstellung kann hier heruntergeladen werden";
}

// Traducir y reemplazar el contenido específico del div greyblock
if ($idiomaSeleccionado != "es") {
    $divGreyblock = traducirDivGreyblock($documento, $idiomaOrigen, $idiomaSeleccionado, $fraseClave);
}
else {
    $divGreyblock = $documento->find('.greyblock')[0]->innerHtml();
}
?>

<link rel="stylesheet" href="../css/delahome.css">


<p class="heading0"><?php echo $textosTraducidos[0]; ?></p>
<p class="heading0"><a href="../../sql/autosdb.sql" target="_blank"><?php echo $textosTraducidos[1]; ?></a></p>
<p class="heading1"><?php echo $textosTraducidos[2]; ?></p>
<hr class="separator">
<div class="greyblock"><?php echo $divGreyblock; ?></div>
<p class="heading1a"><?php echo $textosTraducidos[3]; ?></p>
<div class="content"><?php echo $textosTraducidos[4]; ?></div>

<?php
    include_once "../estructura/pieBT.php";
?>