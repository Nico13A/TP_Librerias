<?php
$Titulo = "Inicio";
include_once("../estructura/cabeceraBT.php");
?>

<link rel="stylesheet" href="../css/delahome.css">

<p class="heading0">Modelo MVC en Programación Web Dinámica</p>

<p class="heading0"><a href="../../sql/autosdb.sql" target="_blank">Se requiere el uso de una BBDD</a></p>
<p class="heading1">Instalación PDWMVC</p>
<hr class="separator">
<div class="greyblock">Tener en cuenta que se debe tener una BBDD creada en su gestor de BBDD llamada <strong>autosdb</strong>. El script para su creacion lo puede descargar de <a href="../../sql/autosdb.sql" target="_blank">autosdb</a></div>
<p class="heading1a">Para tener en cuenta:</p>
<div class="content">Este ejemplo trabaja con un MVC usando Mapeo Objeto relacional con objetos. Para mostrar 2 opciones de implementar el uso del mapeo en las interfaces, se puede observar diferencias entre la implementacion en el uso de Usuarios y de Autos.</div>

<?php
include_once("../estructura/pieBT.php");
/*
// Ver el contenido del caché
if (isset($_SESSION['translations'])) {
    echo '<pre>';
    print_r($_SESSION['translations']);
    echo '</pre>';
} else {
    echo 'No hay traducciones en caché.';
}
*/
?>