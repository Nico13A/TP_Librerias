<?php

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
    extraerTexto($rutaHtml, '.content'),
    extraerTexto($rutaHtml, '.content', '.contenido1'),
    extraerTexto($rutaHtml, '.content', '.contenido2'),
    extraerTexto($rutaHtml, '.content', '.contenido3'),
    extraerTexto($rutaHtml, '.contenido1', 'a'),
    extraerTexto($rutaHtml, '.contenido2', 'a'),
    extraerTexto($rutaHtml, '.contenido3', 'a')
);

//print_r($textosMain);

// Textos de los links a eliminar
$palabrasAEliminar = ["DIDOM", "STATICKIDZ", "RESPECT VALIDATION"];

// Recorreremos los elementos específicos y eliminamos las palabras
for ($i = 7; $i <= 9; $i++) {
    foreach ($palabrasAEliminar as $palabra) {
        $textosMain[$i] = str_replace($palabra, "", $textosMain[$i]);
    }
}
//print_r($textosMain);

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
<div class="content"><?php echo $textosTraducidos[5]; ?></div>
<p class="heading1a"><?php echo $textosTraducidos[4] ?></p>
<div class="content">
    <p class="contenido1">
        <?php echo $textosTraducidos[7] ?><a href="https://github.com/Imangazaliev/DiDOM" target="_blank"><?php echo " " . $textosTraducidos[10] ?></a>
    </p>
    <p class="contenido2">
        <?php echo $textosTraducidos[8] ?><a href="https://github.com/statickidz/php-google-translate-free" target="_blank"><?php echo " " . $textosTraducidos[11] ?></a>
    </p>
    <p class="contenido3">
        <?php echo $textosTraducidos[9] ?><a href="https://respect-validation.readthedocs.io/en/2.3/" target="_blank"><?php echo " " . $textosTraducidos[12] ?></a>
    </p>
</div>

<?php
    include_once "../estructura/pieBT.php";
?>