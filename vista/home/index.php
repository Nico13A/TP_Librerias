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
<div class="content">
    Este ejemplo trabaja con un MVC usando Mapeo Objeto relacional con objetos. Para mostrar 2 opciones de implementar el uso del mapeo en las interfaces, se puede observar diferencias entre la implementacion en el uso de Usuarios y de Autos.
</div>
<p class="heading1a">Investigación</p>
<div class="content">
    <p class="contenido1">
        Utilizamos la biblioteca DiDOM para extraer texto de documentos HTML. DiDOM es una herramienta poderosa que facilita la manipulación de documentos HTML y XML en PHP. Puede encontrar información de esta biblioteca en el siguiente link: <a href="https://github.com/Imangazaliev/DiDOM" target="_blank">DIDOM</a>
    </p>
    <p class="contenido2">
        Luego utilizamos Statickidz PHP Translate para traducir el contenido extraído. Statickz PHP Translate es una biblioteca que facilita la traducción de texto utilizando diferentes servicios de traducción. Puede encontrar información de esta biblioteca en el siguiente link: <a href="https://github.com/statickidz/php-google-translate-free" target="_blank">STATICKIDZ</a>
    </p>
    <p class="contenido3">
        Finalmente, utilizamos Respect Validation para validar los datos de los formularios en el backend. Respect Validation es una biblioteca de validación sencilla y poderosa para PHP. Puede encontrar información de esta biblioteca en el siguiente link: <a href="https://respect-validation.readthedocs.io/en/2.3/" target="_blank">RESPECT VALIDATION</a>
    </p>
</div>



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