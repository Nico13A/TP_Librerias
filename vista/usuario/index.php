<?php
$Titulo = " Gestion de Usuarios ";
include_once("../estructura/cabeceraBT.php");
$datos = data_submitted();
$datos['accion']="listar";
include_once("accion.php");

?>
<link rel="stylesheet" href="../css/delahome.css">
<h3>ABM - Usuarios</h3>
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
        <a class="btn btn-success" role="button" href="editar.php?accion=nuevo">Nuevo</a>
    </div>
</div>


<div class="table-responsive">
    <table class="table table-striped table-sm">
        <thead>
        <tr>
            <th scope="col">DNI</th>
            <th scope="col">Nombre</th>
            <th scope="col">Email</th>
            <th scope="col">Acciones</th>
        </tr>
        </thead>
        <tbody>

<?php
 if(count($lista)>0) {
    foreach ($lista as $uno) {
        echo '<tr><td>'.$uno['dni'].'</td>';
        echo '<td>'.$uno['nombre'].'</td>';
        echo '<td>'.$uno['email'].'</td>';
        echo '<td><a class="btn btn-info" role="button" href="editar.php?accion=editar&dni='.$uno['dni'].'">editar</a>';
        echo '<a class="btn btn-primary" role="button" href="editar.php?accion=borrar&dni='.$uno['dni'].'">borrar</a></td></tr>';
	}
}
?>
        </tbody>
    </table>
</div>


<?php

include_once("../estructura/pieBT.php");

?>
