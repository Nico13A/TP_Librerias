<?php
$Titulo = " Gestion de Autos";
include_once("../estructura/cabeceraBT.php");
$datos = data_submitted();
$datos['accion']="listar";
include_once("accion.php");
?>
<link rel="stylesheet" href="../css/delahome.css">
<h3>ABM - Autos</h3>


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
            <th scope="col">Patente</th>
            <th scope="col">Marca</th>
            <th scope="col">Modelo</th>
            <th scope="col">Año</th>
            <th scope="col">Dueño</th>
            <th scope="col">Acciones</th>
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
        echo '<td><a class="btn btn-info" role="button" href="editar.php?accion=editar&patente='.$uno['patente'].'">editar</a>';
        echo '<a class="btn btn-primary" role="button" href="editar.php?accion=borrar&patente='.$uno['patente'].'">borrar</a></td></tr>';
	}
}
?>
        </tbody>
    </table>
</div>


<?php
include_once("../estructura/pieBT.php");
?>
