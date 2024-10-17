<?php
$Titulo = " Usuario ";
include_once("../estructura/cabeceraBT.php");
$datos = data_submitted();

$objC = new ABMUsuario();
$obj = NULL;
if (isset($datos['dni']) && $datos['dni'] <> -1){
    $listaTabla = $objC->buscar($datos);
    if (count($listaTabla)==1){
        $obj= $listaTabla[0];
    }
}

?>	
<form method="post" action="accion.php" novalidate>
    <input id="dni" name ="dni" type="hidden" value="<?php echo ($obj !=null) ? $obj->getDni() : "-1"?>" readonly required >
    <input id="accion" name ="accion" value="<?php echo ($datos['accion'] !=null) ? $datos['accion'] : "nose"?>" type="hidden">
    <div class="row mb-12">
        <div class="col-sm-12 ">
            <div class="form-group">
                <label for="dni" class="control-label">DNI:</label>
                <input id="dni" name="dni" type="text" class="form-control" value="<?php echo ($obj !=null) ? $obj->getDni() : ""?>" <?php echo ($obj !=null) ? "readonly" : ""?> required pattern="^\d{8}$">
                <div class="invalid-feedback">Por favor ingrese un DNI válido.</div>
            </div>
            <div class="form-group">
                <label for="nombre" class="control-label">Nombre:</label>
                <input id="nombre" name="nombre" type="text" class="form-control" value="<?php echo ($obj !=null) ? $obj->getNombre() : ""?>" required pattern="^[A-Za-zÁÉÍÓÚáéíóúñÑ\s'.-]{5,50}$">
                <div class="invalid-feedback">Por favor ingrese un nombre.</div>
            </div>
            <div class="form-group">
                <label for="email" class="control-label">Correo:</label>
                <input id="email" name="email" type="email" class="form-control" value="<?php echo ($obj !=null) ? $obj->getEmail() : ""?>" required pattern="^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$">
                <div class="invalid-feedback">Por favor ingrese un correo electrónico válido.</div>
            </div>
        </div>
    </div>
    
    <input type="submit" class="btn btn-primary btn-block" value="<?php echo ($datos['accion'] !=null) ? $datos['accion'] : "nose"?>">
</form>
<a href="index.php">Volver</a>

<?php
include_once("../estructura/pieBT.php");
?>